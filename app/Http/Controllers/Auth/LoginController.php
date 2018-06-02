<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Logic\Token;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected $weChatLoginUrl = "https://api.weixin.qq.com/sns/jscode2session";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->tokenService = app(Token::class);
    }

    public function Login()
    {
        $type = request()->input('type');

        if($type == 'weChat'){
            return $this->wechatLogin();
        }

    }

    public function weChatLogin()
    {
        $code = request()->input('code');

        $appId = env('WE_CHAT_APP_ID');
        $secret = env('WE_CHAT_SECRET');

        $url = $this->weChatLoginUrl.'?appid='.$appId.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';

        $http = new Client;
        $response = $http->get($url);

        $result = json_decode((string) $response->getBody(), true);

        return $result['openid'];
    }


    /**
     * 登录
     *
     * @author yezi
     *
     * @return mixed
     */
    public function apiLogin()
    {
        $type = request()->input('type');
        $code = request()->input('code');
        $userInfo = request()->input('user_info');

        try{
            \DB::beginTransaction();

            if($type == 'weChat'){
                $result = $this->apiWeChatLogin($userInfo,$code);
            }

            \DB::commit();
        }catch (\Exception $e){
            \DB::rollBack();
            throw $e;
        }

        return $result;
    }

    /**
     * 微信登录
     *
     * @author yezi
     *
     * @return mixed
     */
    public function apiWeChatLogin($userInfo,$code)
    {
        $weChatAppId = env('WE_CHAT_APP_ID');
        $secret = env('WE_CHAT_SECRET');

        $url = $this->weChatLoginUrl.'?appid='.$weChatAppId.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';

        $http = new Client;
        $response = $http->get($url);

        $result = json_decode((string) $response->getBody(), true);

        $token = $this->tokenService->createToken($userInfo,$result['openid']);

        return $token;
    }
}
