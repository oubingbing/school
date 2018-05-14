<?php

namespace App\Http\Controllers\SignInGuard;

use App\Exceptions\ApiException;
use App\GuardUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisteGuardUser;
use App\Jobs\SendPhoneMessage;
use App\MessageCode;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * 发送短信验证码
     *
     * @author yezi
     *
     * @return array
     * @throws ApiException
     */
    public function sendMessage()
    {
        $mobile = request()->post('mobile');

        if(empty($mobile)){
            throw new ApiException('手机号码不能为空',404);
        }

        dispatch((new SendPhoneMessage($mobile))->onQueue('send_phone_message_code'));

        return ['message'=>'短信已发送'];
    }

    /**
     * 用户登录
     *
     * @return mixed
     * @throws ApiException
     */
    public function login()
    {
        $mobile = request()->post('mobile');
        $code = request()->post('code');

        $messageCode = MessageCode::getEffectMessageCode($mobile,$code);
        if(collect($messageCode)->isEmpty()){
            throw new ApiException('验证码已过期，请重新发送',6000);
        }
        
        $token = $this->getToken($mobile);

        return $token;
    }

    /**
     * 注册用户
     *
     * @author yezi
     *
     * @param RegisteGuardUser $request
     * @return mixed
     */
    public function register(RegisteGuardUser $request)
    {
        $mobile = $request->post('mobile');
        $nickname = $request->post('nickname');
        $avatar = $request->post('avatar');

        $result = GuardUser::create([
            GuardUser::FIELD_MOBILE => $mobile,
            GuardUser::FIELD_NICKNAME => $nickname,
            GuardUser::FIELD_AVATAR => $avatar
        ]);

        return $result;
    }

    /**
     * 获取token
     * 
     * @param $mobile
     * @return mixed
     */
    private function getToken($mobile)
    {
        config(['jwt.user' => '\App\GuardUser']);
        config(['auth.providers.users.model' => GuardUser::class]);

        $user = GuardUser::query()->where(GuardUser::FIELD_MOBILE,$mobile)->first();
        $token = JWTAuth::fromUser($user);
        
        return $token;
    }

    /**
     * 刷新token
     *
     * @author yezi
     *
     * @return mixed
     * @throws ApiException
     */
    public function refreshToken()
    {
        $token = request()->get('token');

        if(!$token){
            throw new ApiException('token不能为空',6000);
        }

        config(['jwt.user' => '\App\GuardUser']);
        config(['auth.providers.users.model' => GuardUser::class]);
        $newToken = JWTAuth::refresh($token);

        return $newToken;
    }

}