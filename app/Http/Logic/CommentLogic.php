<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/17
 * Time: 下午4:14
 */

namespace App\Http\Logic;


use App\Comment;

class CommentLogic
{

    /**
     * 保存评论内容
     *
     * @author yezi
     *
     * @param $commenterId
     * @param $objId
     * @param $content
     * @param $type
     * @param $refCommentId
     * @param null $attachments
     * @param null $collegeId
     * @return mixed
     */
    public function saveComment($commenterId,$objId,$content,$type,$refCommentId,$attachments=null,$collegeId=null)
    {
        $comment = Comment::create([
            Comment::FIELD_ID_COMMENTER=>$commenterId,
            Comment::FIELD_ID_OBJ=>$objId,
            Comment::FIELD_CONTENT=>$content,
            Comment::FIELD_TYPE=>$type,
            Comment::FIELD_ID_REF_COMMENT=>$refCommentId,
            Comment::FIELD_ATTACHMENTS=>$attachments,
            Comment::FIELD_ID_COLLEGE=>$collegeId
        ]);

        return $comment;
    }

    public function comments($objId,$type)
    {
        $comments = Comment::query()
            ->where(Comment::FIELD_ID_OBJ,$objId)
            ->where(Comment::FIELD_TYPE,$type)
            ->get();

        return $comments;
    }

    public function formatComments($comments)
    {

    }

}