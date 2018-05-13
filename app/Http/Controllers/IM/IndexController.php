<?php

namespace App\Http\Controllers\IM;

use App\Events\Chat;
use App\Http\Controllers\Controller;
use GatewayWorker\Lib\Gateway;

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

        Gateway::sendToClient($client_id, json_encode([
            'clientId' => $client_id,
            'type' => 'message',
            'data' => 'this is a message'
        ]));
    }


}