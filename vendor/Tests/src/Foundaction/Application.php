<?php
namespace Tests\Foundaction;

use App\Controllers\IndexController;
use Tests\Config\Config;
use Tests\Containers\Containers;
use Tests\Router\Route;
use Tests\Support\Facades\Facade;

class Application extends Containers
{
    //框架根目录
    protected $basePath;

    //存储服务提供者对象
    protected $serviceProviders;

    //启动服务提供者开关
    protected $booted = false;

    public function __construct($basePath = null)
    {
        if($basePath){
            $this->setBasePath($basePath);
        }
        $this->registerBaseBingings();
        $this->registerCoreContainerAliases();
        Facade::setFacadeApplication($this);
    }

    public function setBasePath($path){
        $this->basePath = rtrim($path,'\/');
    }

    public function getBasePath(){
        return $this->basePath;
    }

    public function registerConfiguredProviders(){
        $providers = $this->make('config')->get('app.provider');
        $this->marASRegisterProviders((new ProviderRegister($this))->load($providers));
    }

    public function marASRegisterProviders($providers){
        foreach ($providers as $provider){
            $this->serviceProviders[] = $provider;
        }
    }

    public function registerBaseBingings(){
        static::setInstance($this);
        $this->instance('app',$this);
    }

    public function registerCoreContainerAliases(){
        $binds = [
            'config' => Config::class,
            'router' => Route::class
        ];

        foreach ($binds as $key => $value){
            $this->bind($key,$value);
        }
    }

    public function boot(){
        if($this->booted){
            return;
        }

        foreach ($this->serviceProviders as $provider){
            //判断服务提供者中是否包含boot方法
            if(method_exists($provider,'boot')){
                $provider->boot();
            }
        }

        $this->booted = true;
    }

}