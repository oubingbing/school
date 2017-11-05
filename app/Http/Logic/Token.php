<?php

namespace App\Http\Logic;

use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class Token
{
    public function getWecChatToken($user)
    {
        $token = JWTAuth::fromUser($user);

        return $token;

    }


}