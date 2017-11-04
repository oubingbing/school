<?php

namespace App\Http\Middleware;

use Closure;

class After
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
        $request->offsetSet('user','test');

        return $next($request);
    }
}
