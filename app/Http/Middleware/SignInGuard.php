<?php

namespace App\Http\Middleware;

use Closure;

class SignInGuard
{
    /**
     * 守护打卡的权限中间件
     *
     * @author
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
