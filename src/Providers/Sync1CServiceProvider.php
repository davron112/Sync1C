<?php

namespace Davron112\Sync1C\Providers;

use Davron112\Jobs\ProductSynchronizationJob;
use Illuminate\Support\ServiceProvider;
use Davron112\Jobs\Contracts\ProductSynchronizationJob as ProductSynchronizationJobInterface;


class Sync1CServiceProvider extends ServiceProvider
{
    /**
     * Boot the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/sync1c.php' => config_path('sync1c.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../tests' => base_path('tests/sync1c')
        ], 'tests');

        $this->app->bind('Davron112\Sync1C\Sync1CServiceInterface', function ($app) {
            $config  = $app['config']['sync1c'];
            $service = $app->make('Davron112\Sync1C\Sync1CService');
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
        $this->app->bind(ProductSynchronizationJobInterface::class, ProductSynchronizationJob::class);
    }
}
