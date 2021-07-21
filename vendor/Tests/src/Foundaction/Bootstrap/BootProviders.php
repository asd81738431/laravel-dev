<?php


namespace Tests\Foundaction\Bootstrap;

use Tests\Foundaction\Application;

class BootProviders
{
    public function bootstrap(Application $app){
        $app->boot();
    }
}