<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\TokenController;
use App\Http\Wechat\UserController;

$api = app('Dingo\Api\Routing\Router');

app('api.exception')->register(function (Exception $exception) {
    $request = Illuminate\Http\Request::capture();
    return app('App\Exceptions\Handler')->render($request, $exception);
});

$api->version('v1', function ($api) {

    $api->group(['prefix' => 'wechat'], function ($api) {


        $api->group(['prefix' => 'auth', 'middleware' => 'before'], function ($api) {

            /** 登录 */
            $api->post('login', LoginController::class . '@login');

            /** 获取微信token */
            $api->post('token', TokenController::class . '@createToken');

            /** 刷新微信token */
            $api->get('refresh_token', TokenController::class . '@refreshToken');

            $api->get('test', TokenController::class . '@test');

        });

        $api->group(['middleware' => ['wechat', 'after', 'before']], function ($api) {

            $api->get('/school', UserController::class . '@school');

        });

    });

});


