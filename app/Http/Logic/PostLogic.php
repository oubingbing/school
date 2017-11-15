<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/13
 * Time: 下午6:16
 */

namespace App\Http\PostLogic;


use App\Post;
use App\User;

class PostLogic
{
    /**
     * 保存新增的贴子
     *
     * @author yezi
     *
     * @param $user
     * @param $content
     * @param null $imageUrls
     * @param null $location
     * @param null $private
     * @return mixed
     */
    public function save($user,$content,$imageUrls=null,$location=null,$private=null)
    {
        $result = Post::create([
            Post::FIELD_ID_POSTER => $user->{User::FIELD_ID},
            Post::FIELD_ID_COLLEGE => $user->{User::FIELD_ID_COLLEGE},
            Post::FIELD_CONTENT => $content,
            Post::FIELD_ATTACHMENTS => $imageUrls,
            Post::FIELD_PRIVATE => $private
        ]);

        return $result;
    }

}