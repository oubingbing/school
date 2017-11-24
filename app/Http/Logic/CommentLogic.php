<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/17
 * Time: 下午4:14
 */

namespace App\Http\Logic;


use App\Comment;
use App\User;

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
        $commenter = User::find($comments['commenter_id']);

        $comments['commenter'] = [
            'id'=>$commenter->{User::FIELD_ID},
            'nickname'=>$commenter->{User::FIELD_NICKNAME},
            'avatar'=>$commenter->{User::FIELD_AVATAR}
        ];

        if($comments[Comment::FIELD_ID_REF_COMMENT]){
            $refComment = Comment::find($comments[Comment::FIELD_ID_REF_COMMENT]);
            $refComment->refCommenter = User::where(User::FIELD_ID,$refComment->{Comment::FIELD_ID_COMMENTER})->select('id','nickname','avatar')->first();
            $comments['ref_comment'] = $refComment;
        }else{
            $comments['ref_comment'] = '';
        }

        return $comments;
    }

}