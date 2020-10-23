<?php

namespace Davron112\Integration1c\Providers;

use Illuminate\Support\ServiceProvider;

class Integration1cServiceProvider extends ServiceProvider
{
    /**
     * Boot the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/integration-1c.php' => config_path('integration-1c.php')
        ], 'config');

        $this->app->bind('Davron112\Integration1c\Integration1cInterface', function ($app) {
            $config  = $app['config']['Integration1c-1c'];
            $service = $app->make('Davron112\Integration1c\Integration1cService');
            $service->setConfig($config);
            return $service;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
