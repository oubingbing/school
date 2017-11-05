<?php

namespace App\Http\Logic;

use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class Token
{
    public function getWecChatToken($openid)
    {
        $user = User::where(User::FIELD_ID_OPENID,$openid)->first();

        $token = JWTAuth::fromUser($user);

        return $token;

    }

}