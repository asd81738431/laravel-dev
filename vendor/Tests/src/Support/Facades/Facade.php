<?php
namespace Tests\Support\Facades;

class Facade
{
    #解析出来的实例
    protected static $resolvedInstance;
    #application对象
    protected static $app;

    /**
     * @info 获得对象实例
     */
    public static function getFacadeRoot(){
        return static::resolvedFacadeInstance(static::getFacadeAccessor());
    }

    /**
     * @info 通过app的make对标识进行解析
     * @param $name
     */
    public static function resolvedFacadeInstance($name){
        if(is_object($name)){
            return $name;
        }

        if(isset(static::$resolvedInstance[$name])){
            return static::$resolvedInstance[$name];
        }

        if(static::$app){
            return static::$resolvedInstance[$name] = static::$app[$name];
        }
    }

    /**
     * @info 注入Application对象
     * @param $app
     */
    public static function setFacadeApplication($app){
        static::$app = $app;
    }

    /**
     * @info 静态的空方法,访问不存在的静态方法时执行
     * @param $name 访问方法名
     * @param $arguments 传递的参数
     */
    public static function __callStatic($name, $arguments){

        $instance = static::getFacadeRoot();

        #$class = static::getFacadeAccessor();
        #$instance = new $class();

        return $instance->$name(...$arguments);
    }

    public static function getFacadeAccessor(){

    }
}