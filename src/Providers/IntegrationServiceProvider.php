<?php

namespace Davron112\Integrations\Providers;

use Davron112\Integrations\Jobs\ProductSynchronizationJob;
use Illuminate\Support\ServiceProvider;
use Davron112\Integrations\Jobs\Contracts\ProductSynchronizationJob as ProductSynchronizationJobInterface;


class IntegrationserviceProvider extends ServiceProvider
{
    /**
     * Boot the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/1c.php' => config_path('1c.php')
        ], 'config');

        $this->app->bind('Davron112\Integrations\IntegrationserviceInterface', function ($app) {
            $config  = $app['config']['1c'];
            $service = $app->make('Davron112\Integrations\IntegrationService');
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
