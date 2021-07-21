<?php
namespace Tests\Containers;

use Tests\Containers\Contacts\Container;

class Containers implements Container,\ArrayAccess
{
    //存储 标识=>类,对象,闭包函数,契约
    protected $bindings = [];

    //共享容器
    protected $instances = [];

    //单例容器
    protected static $instance = [];

    /**
     * @info 设置单例容器
     * @param null $container 容器
     */
    public static function setInstance($container = null){
        static::$instance = $container;
    }

    public static function getInstance(){
        if(is_null(static::$instance)){
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @info 移除绑定容器里的实例 然后将其写入共享容器里
     * @param $abstract
     * @param $instance
     */
    public function instance($abstract,$instance){
        $this->removeBingings($abstract);
        $this->instances[$abstract] = $instance;
    }

    /**
     * @info 移除绑定容器里的实例
     * @param $abstract array-key
     */
    public function removeBingings($abstract){
        if(array_key_exists($abstract,$this->bindings)){
            unset($this->bindings[$abstract]);
        }
    }

    /**
     * @info 绑定容器到框架服务容器中
     * @param $abstract
     * @param null $concrete
     * @param bool $shared 是否单例
     */
    public function bind($abstract,$concrete = null,$shared = false){
        $this->bindings[$abstract]['concrete'] = $concrete;
        //存放单例
        $this->bindings[$abstract]['shared'] = $shared;
    }

    /**
     * @info 绑定单例
     * @param $abstract
     * @param null $concrete
     * @param false $shared
     */
    public function singleton($abstract,$concrete = null,$shared = false){
        $this->bind($abstract,$concrete,$shared =  true);;
    }

    /**
     * @info 解析实例
     * @param $abstract
     * @param array $parameters
     * @return mixed
     */
    public function make($abstract,$parameters = []){
        return $this->resolve($abstract,$parameters);
    }

    /**
     * @info 完善解析方法
     * @param $abstract
     * @param array $parameters
     * @throws \Exception
     */
    public function resolve($abstract,$parameters = []){
        #if(!$this->has($abstract)){
        #    throw new \Exception('解析对象不存在');
        #}

        //如果包含在共享容器里,则直接返回出去
        if(isset($this->instances[$abstract])){
            return $this->instances[$abstract];
        }

        //获取到绑定的值
        #$object = $this->bindings[$abstract]['concrete'];
        $object = $this->getConrete($abstract);

        //判断是否为闭包
        if($object instanceof \Closure){
            return $object();
        }

        //如果不是对象,如 XXX::class(string app\xxx),则为字符串
        //如果是字符串则将字符串当成类名进行实例化
        //如果是对象,则直接返回出去
        if(!is_object($object)){
            $object = new $object(...$parameters);
        }

        //如果是一个单例模式类,则直接将绑定的值写入到共享容器里
        if(!array_key_exists($abstract,$this->bindings)){
            $this->instances[$abstract] = $object;
        }

        return $object;
    }

    public function getConrete($abstract){
        if($this->has($abstract)){
            $abstract = $this->bindings[$abstract]['concrete'];
        }

        return $abstract;
    }

    /**
     * @info 检查共享容器与绑定容器里是否包含这个键名的类
     * @param $abstract
     * @return bool
     */
    public function has($abstract){
        return isset($this->bindings[$abstract]['concrete']) || isset($this->instances[$abstract]);
    }

    /**
     * @info 获取绑定的实例
     * @return array
     */
    public function getBindings(){
        return $this->bindings;
    }

    /**
     * @info 获取共享的实例
     * @return array
     */
    public function getIn(){
        return $this->instances;
    }

    public function offsetExists($offset)
    {
        var_dump('---offsetExists---');
    }

    public function offsetGet($offset)
    {
        return $this->make($offset);
    }

    public function offsetSet($offset, $value)
    {
        var_dump('---offsetSet---');
    }

    public function offsetUnset($offset)
    {
        var_dump('---offsetUnset---');
    }
}