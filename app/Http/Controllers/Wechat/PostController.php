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

        $posts = app(PostLogic::class)->getPostList($user);

        $posts = collect($posts)->map(function ($post)use($user){

            $poster = $post['poster'];
            $post = collect($post)->forget('poster');
            $post['poster']  = [
                'id'=>$poster->id,
                'nickname'=>$poster->nickname,
                'avatar'=>$poster->avatar,
                'college_id'=>$poster->college_id,
                'created_at'=>$poster->created_at,
            ];

            $post['praises'] = app(PraiseLogic::class)->formatBatchPraise($post['praises']);

            $post['comments'] = app(CommentLogic::class)->formatBatchComments($post['comments'],$user);

            if($post[Post::FIELD_ID_POSTER] == $user->{User::FIELD_ID}){
                $post['can_delete'] = true;
            }else{
                $post['can_delete'] = false;
            }

            return $post;
        });

        return collect($posts)->toArray();
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