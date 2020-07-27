<?php

namespace Vandar\Laravel;

use Illuminate\Support\ServiceProvider;
use Vandar\Drivers\DriverInterface;
use Vandar\Drivers\RestDriver;
use Vandar\Vandar;

class VandarServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DriverInterface::class, function () {
            return new RestDriver();
        });
        $this->app->singleton('Vandar', function () {
            $apiKey = config('services.vandar.api', config('Vandar.apiKey', 'fb1a319b28697e008d1l2d9adabcab4187474f73'));
            $vandar = new Vandar($apiKey, $this->app->make(DriverInterface::class));
            if (config('services.vandar.test', false)) {
                $vandar ->enableTest();
            }
            return $vandar;
        });
    }

    /**
     * Publish the plugin configuration.
     */
    public function boot()
    {
        //
    }
}