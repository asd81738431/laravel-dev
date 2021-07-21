<?php

use Tests\Foundaction\Application;

if(!function_exists('app')){
    function app($abstract = null,array $parameters = []){
        if(is_null($abstract)){
            return Application::getInstance();
        }

        return Application::getInstance()->make($abstract,$parameters);
    }
}