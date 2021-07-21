<?php
namespace Tests\Foundaction\Bootstrap;

use Tests\Foundaction\Application;

class RegisterProviders extends Application
{
    public function bootstrap(Application $app){
        $app->registerConfiguredProviders();
    }
}