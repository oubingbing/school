<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\Flysystem\Exception;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

      /*  app('Dingo\Api\Exception\Handler')->register(function (\Exception $e) {
            $class = get_class($e);

            switch ($class) {
                case \Tymon\JWTAuth\Exceptions\TokenExpiredException::class:
                    throw new Exception('token过期', null, '40001');
                    break;
                case \Tymon\JWTAuth\Exceptions\TokenInvalidException::class:
                    throw new Exception('token无效' . $e->getMessage(), null, '40001');
                    break;
            }

        });*/
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

    }
}
