<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/12/18
 * Time: 上午10:31
 */

namespace App\Http\Logic;


use App\Http\Repository\FriendRepository;

class FriendLogic
{
    protected $friend;

    public function __construct(FriendRepository $friendRepository)
    {
        $this->friend = $friendRepository;
    }

    /**
     * 新增好友
     *
     * @author yezi
     *
     * @param $userId
     * @param $friendId
     * @return mixed
     */
    public function createFriend($userId,$friendId)
    {
        return $this->friend->saveFriend($userId,$friendId);
    }

    public function checkFriendUnique($userId,$friendId)
    {
        return $this->friend->checkFriend($userId,$friendId);
    }

}