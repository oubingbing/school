<?php

namespace App\Http\Logic;

use App\Http\Repository\FollowRepository;

class FollowLogic
{
    protected $follow;

    public function __construct(FollowRepository $followRepository)
    {
        $this->follow = $followRepository;
    }

    /**
     * 关注
     *
     * @author yezi
     *
     * @param $userId
     * @param $objId
     * @param $objType
     *
     * @return mixed
     */
    public function follow($userId, $objId, $objType)
    {
        $result = $this->follow->checkFollow($userId, $objId, $objType);
        if (!$result) {
            $result = $this->follow->createContact($userId, $objId, $objType);
        }

        return $result;
    }

    /**
     * 取消关注
     *
     * @author yezi
     *
     * @param $userId
     * @param $objId
     * @param $objType
     *
     * @return mixed
     */
    public function cancelFollow($userId, $objId, $objType)
    {
        return $this->follow->breakFollow($userId, $objId, $objType);
    }

    /**
     * 用户关注好友
     *
     * @author yezi
     *
     * @param $userId
     * @param $objId
     * @param $objType
     *
     * @return mixed
     */
    public function userFollow($userId, $objId, $objType)
    {
        $result = $this->follow->getUserFollow($userId, $objId, $objType);

        return $result;
    }

    /**
     * 检测关注
     *
     * @author yezi
     *
     * @param $userId
     * @param $objId
     * @param $type
     *
     * @return mixed
     */
    public function checkFollow($userId, $objId, $type)
    {
        return $this->follow->checkFollow($userId, $objId, $type);
    }

}