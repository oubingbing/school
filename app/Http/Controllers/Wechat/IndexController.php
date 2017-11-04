<?php

namespace App\Http\Wechat;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{

    public function index()
    {
        $user = request()->get('user');

        return $user;
    }

    public function user()
    {
        phpinfo();
    }

}