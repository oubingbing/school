<?php

namespace App\Http\Controllers\IM;

use App\Events\Chat;
use App\Http\Controllers\Controller;
use GatewayClient\Gateway;

class IndexController extends Controller
{
    public function chatRoom()
    {
        return view('test.redis');
    }
    public function sendMessage()
    {
        $content = request()->input('content');

        event(new Chat('慧怡'));
    }

    public function socket()
    {
        return view('test.socket');
    }

    public function bindSocket()
    {
        $client_id = request()->post('client_id');

        Gateway::$registerAddress = '127.0.0.1:1236';

        // 假设用户已经登录，用户uid和群组id在session中
        $uid      = 110;
        Gateway::bindUid($client_id, $uid);

        $message = ['client_id'=>$client_id];
        // 向任意uid的网站页面发送数据
        Gateway::sendToUid($uid, $message);
    }


}