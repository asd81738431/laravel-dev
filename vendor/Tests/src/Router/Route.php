<?php
namespace Tests\Router;

class Route
{
    //保存的路由
    protected $routes = [];

    protected $namespace;

    //请求方法
    protected $verbs = ["GET","POST","PUT","DELETE","PATCH"];

    public function get($uri,$action){
        $this->addRouter(["GET"],$uri,$action);
    }
    public function post($uri,$action){
        $this->addRouter(["POST"],$uri,$action);
    }
    public function any($uri,$action){
        $this->addRouter($this->verbs,$uri,$action);
    }

    //添加路由
    public function addRouter($methods,$uri,$action){
        foreach ($methods as $method){
            $this->routes[$method][$uri] = $action;
        }
    }

    public function register($routers){
        require_once $routers;
    }

    public function getRouter(){
        return $this->routes;
    }
}