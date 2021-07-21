<?php
namespace Tests\Foundaction;

class ProviderRegister
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function load($providers){
        foreach ($providers as $provider){
            $providerArr[] = $this->register($provider);
        }

        return $providerArr;
    }

    public function register($provider){
        if(is_string($provider)){
            $provider = $this->resolveProvider($provider);
//            return $provider;
        }
        $provider->register();

        return $provider;
    }

    public function resolveProvider($provider){
        return new $provider($this->app);
    }
}