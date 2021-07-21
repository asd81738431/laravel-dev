<?php
namespace Tests\Support;

use Tests\Foundaction\Application;

class ServiceProvider
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    #服务提供者的注册方法,用于子类重写
    public function register(){}
    #服务提供者的启动方法
    public function boot(){}
}