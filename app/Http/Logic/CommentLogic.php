<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/17
 * Time: 下午4:14
 */

namespace App\Http\Logic;


use App\Comment;
use App\Post;
use App\SaleFriend;
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
            Comment::FIELD_OBJ_TYPE=>$type,
            Comment::FIELD_ID_REF_COMMENT=>$refCommentId,
            Comment::FIELD_ATTACHMENTS=>$attachments,
            Comment::FIELD_ID_COLLEGE=>$collegeId
        ]);

        return $comment;
    }

    public function incrementComment($type,$objId)
    {
        switch ($type){
            case Comment::ENUM_OBJ_TYPE_POST:
                $result = Post::query()->where(Post::FIELD_ID,$objId)->increment(Post::FIELD_COMMENT_NUMBER);
                break;
            case Comment::ENUM_OBJ_TYPE_SALE_FRIEND:
                $result = SaleFriend::query()->where(SaleFriend::FIELD_ID,$objId)->increment(SaleFriend::FIELD_COMMENT_NUMBER);
                break;
            default:
                $result = Post::query()->where(Post::FIELD_ID,$objId)->increment(Post::FIELD_COMMENT_NUMBER);
                break;
        }

        return $result;
    }

    /**
     * 获取评论
     *
     * @author yezi
     *
     * @param $objId
     * @param $objType
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function comments($objId,$objType)
    {
        $comments = Comment::query()
            ->where(Comment::FIELD_ID_OBJ,$objId)
            ->where(Comment::FIELD_OBJ_TYPE,$objType)
            ->get();

        return $comments;
    }

    /**
     * 批量格式化评论
     *
     * @author yezi
     *
     * @param $comments
     * @param $user
     * @return array
     */
    public function formatBatchComments($comments,$user)
    {
        return collect($comments)->map(function($item)use($user){

            return $this->formatSingleComments($item,$user);

        })->toArray();
    }

    /**
     * 格式化单条评论
     *
     * @author yezi
     *
     * @param $comment
     * @param $user
     * @return mixed
     */
    public function formatSingleComments($comment,$user)
    {
        $commenter = User::find($comment['commenter_id']);

        $this->formatBatchComments($comment->subComments,$user);

        $comment['commenter'] = [
            'id'=>$commenter->{User::FIELD_ID},
            'nickname'=>$commenter->{User::FIELD_NICKNAME},
            'avatar'=>$commenter->{User::FIELD_AVATAR}
        ];

        if($comment[Comment::FIELD_ID_REF_COMMENT]){
            $refComment = Comment::withTrashed()->find($comment[Comment::FIELD_ID_REF_COMMENT]);
            if($refComment){
                $refComment->refCommenter = User::where(User::FIELD_ID,$refComment->{Comment::FIELD_ID_COMMENTER})->select('id','nickname','avatar')->first();
                $comment['ref_comment'] = $refComment;
            }else{
                $comment['ref_comment'] = '';
            }
        }else{
            $comment['ref_comment'] = '';
        }

        if($comment[Comment::FIELD_ID_COMMENTER] == $user->{User::FIELD_ID}){
            $comment['can_delete'] = true;
        }else{
            $comment['can_delete'] = false;
        }

        return $comment;
    }

}