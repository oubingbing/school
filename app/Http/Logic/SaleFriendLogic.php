<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/28
 * Time: 上午11:47
 */

namespace App\Http\Logic;


use App\Colleges;
use App\Comment;
use App\Follow;
use App\SaleFriend;
use App\User;

class SaleFriendLogic
{
    protected $commentLogic;

    public function __construct(CommentLogic $commentLogic)
    {
        $this->commentLogic = $commentLogic;
    }

    /**
     * 新增
     *
     * @author yezi
     *
     * @param $userId
     * @param $name
     * @param $gender
     * @param $major
     * @param $expectation
     * @param $introduce
     * @param null $collegeId
     * @param $attachments
     * @return mixed
     */
    public function save($userId, $name, $gender, $major, $expectation, $introduce, $attachments, $collegeId = null)
    {
        $result = SaleFriend::create([
            SaleFriend::FIELD_ID_OWNER    => $userId,
            SaleFriend::FIELD_ID_COLLEGE  => $collegeId,
            SaleFriend::FIELD_NAME        => $name,
            SaleFriend::FIELD_GENDER      => $gender,
            SaleFriend::FIELD_MAJOR       => $major,
            SaleFriend::FIELD_EXPECTATION => $expectation,
            SaleFriend::FIELD_INTRODUCE   => $introduce,
            SaleFriend::FIELD_ATTACHMENTS => $attachments
        ]);

        return $result;
    }

    /**
     * 格式化单挑数据
     *
     * @author yezi
     *
     * @param $saleFriend
     * @param $user
     * @return mixed
     */
    public function formatSingle($saleFriend, $user)
    {
        $saleFriend->can_delete = $this->canDeleteSaleFriend($saleFriend, $user);

        $saleFriend->can_chat = $this->canChat($saleFriend, $user);

        $saleFriend['comments'] = collect($this->commentLogic->formatBatchComments($saleFriend['comments'], $user))->sortByDesc(Comment::FIELD_CREATED_AT)->values();

        $saleFriend['follow'] = app(FollowLogic::class)->checkFollow($user->id, $saleFriend['id'], Follow::ENUM_OBJ_TYPE_SALE_FRIEND) ? true : false;

        $saleFriend['show_college'] = false;
        $saleFriend['college'] = null;
        if(!$user->{User::FIELD_ID_COLLEGE}){
            if($saleFriend['college_id']){
                $saleFriend['show_college'] = true;
                $saleFriend['college'] = Colleges::where(Colleges::FIELD_ID,$saleFriend['college_id'])->value(Colleges::FIELD_NAME);
            }
        }

        return $saleFriend;
    }

    /**
     * 是否可以删除当前数据
     *
     * @author yezi
     *
     * @param $saleFriend
     * @param $user
     * @return bool
     */
    public function canDeleteSaleFriend($saleFriend, $user)
    {
        $poster = $saleFriend['poster'];
        if ($poster->id == $user->id) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * 是否可以与之聊天
     *
     * @author yezi
     *
     * @param $saleFriend
     * @param $user
     * @return bool
     */
    public function canChat($saleFriend, $user)
    {
        $poster = $saleFriend['poster'];
        if ($poster->id != $user->id) {
            return true;
        } else {
            return false;
        }
    }


}