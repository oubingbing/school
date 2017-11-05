<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/4
 * Time: 下午1:21
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Logic\Token;
use App\Http\Logic\UserLogic;
use App\User;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;

class TokenController extends Controller
{

    /**
     * 获取token
     *
     * @author yezi
     *
     * @return mixed
     * @throws Exception
     */
    public function createToken()
    {
        $openId = request()->input('open_id');
        $userInfo = request()->input('user_info');

        if (empty($openId) || empty($userInfo)){
            throw new Exception('用户信息不用为空');
        }

        try{
            DB::beginTransaction();

            $user = User::where(User::FIELD_ID_OPENID,$openId)->first();
            if(!$user){
                $user = new UserLogic();
                $user->createWeChatUser($openId,$userInfo);
            }

            dd($userInfo);

            $tokenCreate = new Token();

            $token = $tokenCreate->getWecChatToken($openId);

            DB::commit();

        }catch (Exception $e){
            DB::rollBack();
        }

        return $token;
    }

}