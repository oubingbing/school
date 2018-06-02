<?php

namespace App\Http\Wechat;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\User;

class IndexController extends Controller
{
    /**
     * 获取用户信息
     *
     * @author yezi
     *
     * @return mixed
     */
    public function index()
    {
        $user = request()->get('user');

        return $user;
    }

    /**
     * 获取应用的状态
     *
     * @author yezi
     *
     * @return mixed
     * @throws ApiException
     */
    public function config()
    {
        $allianceKey = request()->input('app_id');
        if(!$allianceKey){
            throw new ApiException('app_id不能为空',500);
        }

        return 3;
    }

    public function service()
    {
        $user = request()->input('user');

        return 4;
    }

}