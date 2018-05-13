<?php

namespace App\Http\Controllers\IM;

use App\Events\Chat;
use App\Http\Controllers\Controller;
use GatewayClient\Gateway;
use Illuminate\Support\Facades\Log;
use Workermen\GatewayHelper;

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
        $clientId = request()->get('client_id');
        $gatewayHelper = app(GatewayHelper::class);

        $uid      = 110;
        $gatewayHelper->bindUser($clientId,$uid);

        $message = ['client_id'=>$clientId,'type'=>'test'];
        $gatewayHelper->sendToUserId($uid,$message);

        return ['ok'];
    }


}