<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/13
 * Time: 下午6:16
 */

namespace App\Http\Wechat;


use App\Comment;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Logic\CommentLogic;
use App\Http\Logic\PaginateLogic;
use App\Http\Logic\PraiseLogic;
use App\Http\PostLogic\PostLogic;
use App\Post;
use App\Praise;
use App\User;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

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

        if(empty($content)){
            throw new ApiException('内容不能为空',6000);
        }

        $result = app(PostLogic::class)->save($user,$content,$imageUrls,$location,$private);

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
        $pageSize = request()->input('page_size');
        $pageNumber = request()->input('page_number');

        $pageParams = ['page_size'=>$pageSize, 'page_number'=>$pageNumber];

        $query =  Post::with(['poster','praises','comments'])->where(Post::FIELD_ID_COLLEGE,$user->{User::FIELD_ID_COLLEGE})
            ->orderBy(Post::FIELD_CREATED_AT,'desc');

        $posts = app(PaginateLogic::class)->paginate($query,$pageParams, '*',function($post)use($user){
            return app(PostLogic::class)->formatSinglePost($post,$user);
        });

        return collect($posts)->toArray();
    }

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