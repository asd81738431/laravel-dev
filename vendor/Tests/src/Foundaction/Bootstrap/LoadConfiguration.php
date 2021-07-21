<?php
namespace Tests\Foundaction\Bootstrap;

use Tests\Foundaction\Application;

class LoadConfiguration
{
    public function bootstrap(Application $app){
        $config = $app->make('config')->phpParser($app->getBasePath().'/config/');
        $app->instance('config',$config);
    }
}