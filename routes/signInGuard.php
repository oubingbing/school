<?php

$api = app('Dingo\Api\Routing\Router');

app('api.exception')->register(function (Exception $exception) {
    $request = Illuminate\Http\Request::capture();

    return app('App\Exceptions\Handler')->render($request, $exception);
});

$api->version('v1', function ($api) {
    $api->group(['prefix' => 'sign_guard'], function ($api) {
    });
});