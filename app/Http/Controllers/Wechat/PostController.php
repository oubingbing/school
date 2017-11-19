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
use App\Http\PostLogic\PostLogic;
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

        $posts = collect($posts)->map(function ($post){

            $poster = $post['poster'];
            $post = collect($post)->forget('poster');
            $post['poster']  = [
                'id'=>$poster->id,
                'nickname'=>$poster->nickname,
                'avatar'=>$poster->avatar,
                'college_id'=>$poster->college_id,
                'created_at'=>$poster->created_at,
            ];

           $post['praises'] = collect($post['praises'])->map(function ($item){

               $praiseUser = User::find($item['owner_id']);
               return [
                    'id'=>$item['id'],
                    'owner_id'=>$item[Praise::FIELD_ID_OWNER],
                    'obj_type'=>$item[Praise::FIELD_OBJ_TYPE],
                    'college_id'=>$item[Praise::FIELD_ID_COLLEGE],
                    'user_id'=>$praiseUser->id,
                    'nickname'=>$praiseUser->{User::FIELD_NICKNAME},
                    'avatar'=>$praiseUser->{User::FIELD_AVATAR}
                ];

            });

            $post['comments'] = collect($post['comments'])->map(function($item){

                $commenter = User::find($item['commenter_id']);

                $item['commenter'] = [
                    'id'=>$commenter->{User::FIELD_ID},
                    'nickname'=>$commenter->{User::FIELD_NICKNAME},
                    'avatar'=>$commenter->{User::FIELD_AVATAR}
                ];

                return $item;

            });

            return $post;
        });

        return collect($posts)->toArray();
    }

}