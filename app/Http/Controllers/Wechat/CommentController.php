<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/17
 * Time: 下午4:14
 */

namespace App\Http\Wechat;


use App\Comment;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Logic\CommentLogic;
use App\User;

class CommentController extends Controller
{
    /**
     * 评论
     *
     * @author yezi
     *
     * @return array
     */
    public function store()
    {
        $user = request()->input('user');
        $commenterId = $user->{User::FIELD_ID};
        $collegeId = $user->{User::FIELD_ID_COLLEGE};
        $objId = request()->input('obj_id');
        $content = request()->input('content');
        $type = request()->input('type');
        $refCommentId = request()->input('ref_comment_id',null);
        $attachments = request()->input('attachments',null);

        $result = app(CommentLogic::class)->saveComment($commenterId, $objId, $content, $type, $refCommentId, $attachments, $collegeId);

        return app(CommentLogic::class)->formatSingleComments($result,$user);
    }

    /**
     * 删除评论
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
            throw new ApiException('404',6000);
        }

        $result = Comment::where(Comment::FIELD_ID,$id)->where(Comment::FIELD_ID_COMMENTER,$user->{User::FIELD_ID})->delete();
        return $result;
    }

}