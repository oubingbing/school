<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/12/18
 * Time: 上午10:32
 */

namespace App\Http\Repository;


use App\Friend;

class FriendRepository
{
    protected $friend;

    public function __construct(Friend $friend)
    {
        $this->friend = $friend;
    }

    public function saveFriend($userId,$friendId,$nickname,$friendGroupId,$type)
    {
        $result = $this->friend->create([
            Friend::FIELD_ID_USER=>$userId,
            Friend::FIELD_ID_FRIEND=>$friendId,
            Friend::FIELD_ID_FRIEND_GROUP=>$friendGroupId,
            Friend::FIELD_NICKNAME=>$nickname,
            Friend::FIELD_TYPE=>$type
        ]);

        return $result;
    }

}