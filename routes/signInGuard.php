<?php

use App\Http\Controllers\SignInGuard\AuthController;

$api = app('Dingo\Api\Routing\Router');

app('api.exception')->register(function (Exception $exception) {
    $request = Illuminate\Http\Request::capture();

    return app('App\Exceptions\Handler')->render($request, $exception);
});

$api->version('v1', function ($api) {

    $api->group(['prefix' => 'sign_guard', 'middleware' => 'before'], function ($api) {

        $api->group(['prefix' => 'auth'], function ($api) {

            /** 发送短信 */
            $api->post('/send_message',AuthController::class.'@sendMessage');

            /** 注册 */
            $api->post('/register',AuthController::class.'@register');

            /** 登录 */
            $api->post('/getToken',AuthController::class.'@login');

            /** 刷新token */
            $api->post('/refresh_token',AuthController::class.'@refreshToken');

        });

    });
});