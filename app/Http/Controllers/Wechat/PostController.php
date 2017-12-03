<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/13
 * Time: 下午6:16
 */

namespace App\Http\Wechat;


use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Logic\PaginateLogic;
use App\Http\PostLogic\PostLogic;
use App\Post;
use App\User;
use League\Flysystem\Exception;

class PostController extends Controller
{
    /**
     * 发表贴子
     *
     * @author yezi
     *
     * @return array
     * @throws ApiException
     */
    public function store()
    {
        $user = request()->input('user');
        $content = request()->input('content');
        $imageUrls = request()->input('attachments');
        $location = request()->input('location');
        $private = request()->input('private');

        try{
            \DB::beginTransaction();

            if(empty($content)){
                throw new ApiException('内容不能为空',6000);
            }

            $result = app(PostLogic::class)->save($user,$content,$imageUrls,$location,$private);

            \DB::commit();
        }catch (Exception $e){

            \DB::rollBack();
            throw new ApiException($e,60001);
        }

        return collect($result)->toArray();
    }

    /**
     * 获取帖子列表
     *
     * @author yezi
     *
     * @return array
     */
    public function postList()
    {
        $user = request()->input('user');
        $pageSize = request()->input('page_size',10);
        $pageNumber = request()->input('page_number',1);

        $pageParams = ['page_size'=>$pageSize, 'page_number'=>$pageNumber];

        $query =  Post::query()->with(['poster','praises','comments'])->orderBy(Post::FIELD_CREATED_AT,'desc');
        if($user->{User::FIELD_ID_COLLEGE}){
            $query->where(Post::FIELD_ID_COLLEGE,$user->{User::FIELD_ID_COLLEGE});
        }

        $posts = app(PaginateLogic::class)->paginate($query,$pageParams, '*',function($post)use($user){
            return app(PostLogic::class)->formatSinglePost($post,$user);
        });

        return collect($posts)->toArray();
    }

    /**
     * 获取最新的贴子
     *
     * @author yezi
     *
     * @return static
     * @throws ApiException
     */
    public function getMostNewPost()
    {
        $user = request()->input('user');
        $time = request()->input('date_time');

        if(empty($time)){
            throw new ApiException('参数错误',60001);
        }

        $posts = app(PostLogic::class)->getPostList($user,$time);

        $posts = collect($posts)->map(function ($post)use($user){
           return app(PostLogic::class)->formatSinglePost($post,$user);
        });

        return $posts;
    }

    /**
     * 删除帖子
     *
     * @author yezi
     *
     * @param $id
     * @return mixed
     * @throws ApiException
     */
    public function delete($id)
    {
        $user = request()->input('user');

        if(empty($id)){
            throw new ApiException('404',null,'60001');
        }

        $result = Post::where(Post::FIELD_ID,$id)->where(Post::FIELD_ID_POSTER,$user->{User::FIELD_ID})->delete();

        return $result;
    }

}