<?php

namespace App\Http\Logic;

use App\Exceptions\ApiException;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class Token
{
    public function getWecChatToken($user)
    {
        $token = JWTAuth::fromUser($user);

        return $token;
    }

    /**
     * 获取token
     *
     * @author yezi
     *
     * @return mixed
     * @throws Exception
     */
    public function createToken($userInfo,$openId)
    {
        if (empty($openId) || empty($userInfo)){
            throw new ApiException('用户信息不用为空',6000);
        }

        $user = User::where(User::FIELD_ID_OPENID,$openId)->first();

        if(!$user){
            $userLogin = new UserLogic();
            $user = $userLogin->createWeChatUser($openId,$userInfo);
        }

        $token = $this->getWecChatToken($user);

        return $token;
    }

}