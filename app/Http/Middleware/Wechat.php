<?php

namespace App\Http\Middleware;

use App\User;
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
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);//无权限用户
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());//401

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());//400

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());//500没有提供token

        }

        $user = User::where(User::FIELD_ID_OPENID,$user->{User::FIELD_ID_OPENID})->first();

        $request->offsetSet('user',$user);

        return $next($request);
    }
}
