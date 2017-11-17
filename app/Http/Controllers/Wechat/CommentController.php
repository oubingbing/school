<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/17
 * Time: 下午4:14
 */

namespace App\Http\Wechat;


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
        $commenterId = request()->input('commenter_id');
        $objId = request()->input('obj_id');
        $content = request()->input('content');
        $type = request()->input('type');
        $refCommentId = request()->input('ref_comment_id');
        $attachments = request()->input('attachments');
        $collegeId = $user->{User::FIELD_ID_COLLEGE};

        $result = app(CommentLogic::class)->saveComment($commenterId, $objId, $content, $type, $refCommentId, $attachments, $collegeId);

        return collect($result)->toArray();
    }

}