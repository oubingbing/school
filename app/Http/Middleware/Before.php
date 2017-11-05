<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class Before
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
        $response = $next($request);

        return $this->addResponseMate($response);
    }

    /**
     * 添加mate
     *
     * @author yezi
     *
     * @param $response
     * @return array
     */
    public function addResponseMate($response)
    {
        return [
            'data'=>$response->original,
            'json_api'=>[
                'mate'=>[
                    'name'=>'Json Api note',
                    'copyright'=>Carbon::now()->year.' ouzhibing@outlook.com',
                    'power_by'=>'yezi'
                ]
            ]
        ];
    }
}
