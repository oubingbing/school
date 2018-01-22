<?php

namespace App\Http\Wechat;

use App\Http\Controllers\Controller;
use App\User;

class IndexController extends Controller
{

    public function index()
    {
        $user = request()->get('user');

        return $user;
    }

}