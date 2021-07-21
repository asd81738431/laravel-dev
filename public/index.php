<?php
require_once __DIR__."/../vendor/autoload.php";

use Tests\Foundaction\Application;

#第一步:创建app应用实例
$app = new Application($_ENV['APP_BASE_PATH'] ?? dirname(__DIR__));

#第二步:绑定内核到app容器
$app->singleton('kernel',\Tests\Foundaction\Http\Kernel::class);
$kernel = $app->make('kernel',[$app]);
#开始处理请求
$kernel->handle();

var_dump($app->make('router')->getRouter());