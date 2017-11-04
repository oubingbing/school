<?php

namespace App\Http\Middleware;

use Closure;
use League\Flysystem\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class Wechat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $request->offsetSet('user',$user);

        return $next($request);
    }
}
