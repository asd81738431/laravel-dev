<?php
namespace Tests\Containers\Contacts;

interface Container
{
    /**
     * @info 绑定容器到框架服务容器中
     * @return mixed
     */
    public function bind($abstract,$concrete = null);

    /**
     * @info 解析框架服务容器中的容器,取得类对象
     * @return mixed
     */
    public function make($abstract,$parameters = []);
}