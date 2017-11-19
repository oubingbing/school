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
use App\Http\Controllers\QiNiuController;
use App\Http\Wechat\CommentController;
use App\Http\Wechat\PostController;
use App\Http\Wechat\PraiseController;
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

        });

        $api->group(['middleware' => ['wechat', 'after', 'before']], function ($api) {

            /** 获取个人学校 */
            $api->get('/school', UserController::class . '@school');

            /** 获取随机学校 */
            $api->get('/recommend_school',UserController::class . '@recommendSchool');

            /** 设置学校 */
            $api->patch('/set/{id}/college',UserController::class . '@setCollege');

            /** 搜索学校 */
            $api->get('search/{name}/college',UserController::class . '@searchCollege');

            /** 获取七牛上传token */
            $api->get('upload_token',QiNiuController::class . '@getUploadToken');

            /** 发表贴子 */
            $api->post('post',PostController::class . '@store');

            /** 贴子列表 */
            $api->get('/post',PostController::class . '@postList');

            /** 评论 */
            $api->post('/comment',CommentController::class . '@store');

            /** 点赞 */
            $api->post('/praise',PraiseController::class . '@store');

        });

    });

});


