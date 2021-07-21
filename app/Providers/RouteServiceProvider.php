<?php
namespace App\Providers;

use App\Controllers\IndexController;
use Tests\Support\Facades\Router;
use Tests\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    //服务提供者注册方法
    public function register()
    {
        $this->app->instance('router',$this->app->make('router',[$this->app]));
    }

    //服务提供者启动方法
    public function boot()
    {
        //在这里添加路由的地址目录
        Router::register($this->app->getBasePath().'/routes/web.php');
    }
}