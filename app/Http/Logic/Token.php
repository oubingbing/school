<?php

namespace App\Http\Logic;

use Tymon\JWTAuth\Facades\JWTAuth;

class Token
{
    public function getWecChatToken($user)
    {
        $token = JWTAuth::fromUser($user);

        return $token;
    }

    public function refreshWeChatToken()
    {

    }


}