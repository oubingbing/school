<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/27
 * Time: 上午11:17
 */

namespace App\Http\Wechat;


use App\Http\Controllers\Controller;

class SaleFriendController extends Controller
{
    public function save()
    {
        $user = request()->input('user');
        $name = request()->input('name');
        $gender = request()->input('gender');
        $major = request()->input('major');

    }

}