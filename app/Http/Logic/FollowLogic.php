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

    public function follow($userId, $objId, $objType)
    {
        $result = $this->follow->checkFollow($userId, $objId, $objType);
        if (!$result) {
            $result = $this->follow->createContact($userId, $objId, $objType);
        }

        return $result;
    }

    public function cancelFollow($userId, $objId, $objType)
    {
        return $this->follow->breakFollow($userId, $objId, $objType);
    }

    public function userFollow($userId, $objId, $objType)
    {
        $result = $this->follow->getUserFollow($userId, $objId, $objType);

        return $result;
    }

    public function checkFollow($userId, $objId, $type)
    {
        return $this->follow->checkFollow($userId, $objId, $type);
    }

}