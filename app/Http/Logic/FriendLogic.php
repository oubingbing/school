<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/12/18
 * Time: 上午10:31
 */

namespace App\Http\Logic;


use App\Friend;
use App\Http\Repository\ChatRepository;
use App\Http\Repository\FriendRepository;

class FriendLogic
{
    protected $friend;
    protected $chat;

    public function __construct(FriendRepository $friendRepository,ChatRepository $chatRepository)
    {
        $this->friend = $friendRepository;
        $this->chat = $chatRepository;
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

    /**
     * 检测是否已存在该好友
     *
     * @author yezi
     *
     * @param $userId
     * @param $friendId
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function checkFriendUnique($userId,$friendId)
    {
        return $this->friend->checkFriend($userId,$friendId);
    }

    /**
     * 好友列表
     *
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function friends($userId)
    {
        $friends = $this->friend->friendList($userId);

        return $friends;
    }

    public function format($friend)
    {
        $friend->newMessageNumber = $this->chat->countNewChat($friend->{Friend::FIELD_ID_USER},$friend->{Friend::FIELD_ID_FRIEND});

        return $friend;
    }

}