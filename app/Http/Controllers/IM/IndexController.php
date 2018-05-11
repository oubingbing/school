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
        Gateway::$registerAddress = '112.74.51.187:7272';


        Gateway::bindUid('123', '22');
    }

    public function sendSocket()
    {
        Gateway::$registerAddress = '112.74.51.187:7272';

        Gateway::sendToUid('22', 'hello world');
    }

}