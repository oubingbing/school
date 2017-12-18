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

    public function createFriend($userId,$friendId,$nickname,$friendGroupId,$type)
    {
        return $this->friend->saveFriend($userId,$friendId,$nickname,$friendGroupId,$type);
    }

}