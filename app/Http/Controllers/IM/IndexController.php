<?php

namespace App\Http\Controllers\IM;

use App\Events\Chat;
use App\Http\Controllers\Controller;

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

}