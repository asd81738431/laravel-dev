<?php
namespace Tests\Foundaction\Http;

use Tests\Foundaction\Application;
use Tests\Foundaction\Bootstrap\BootProviders;
use Tests\Foundaction\Bootstrap\RegisterFacades;
use Tests\Foundaction\Bootstrap\LoadConfiguration;
use Tests\Foundaction\Bootstrap\RegisterProviders;

class Kernel
{
    //app对象实例
    protected $app;
    //保存或者注册服务提供者
    protected $bootstrappers = [
        RegisterFacades::class,
        LoadConfiguration::class,
        RegisterProviders::class,
        BootProviders::class
    ];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle($request = null){
        $this->sendRequestThroughRouter();
    }

    protected function sendRequestThroughRouter(){
        $this->bootstrap();
    }

    protected function bootstrap(){
        foreach ($this->bootstrappers as $bootstrapper){
            $this->app->make($bootstrapper)->bootstrap($this->app);
        }
    }
}