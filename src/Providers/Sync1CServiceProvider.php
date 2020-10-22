<?php

namespace Davron112\Sync1C\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;

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
            __DIR__ . '/../../config/1c-sync.php' => config_path('sync1c.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../tests' => base_path('tests/sync1c')
        ], 'tests');

        $this->app->bind('Davron112\Sync1C\Sync1CServiceInterface', function ($app) {
            $config  = $app['config']['sync1c'];
            $service = $app->make('Davron112\Sync1C\Sync1CService');
            $service->setConfig($config);

            if (Cache::has($config['token_cache_name'])) {
                $token = Cache::get($config['token_cache_name']);
            } else {
                $token = $service->getProductService()->login();
                Cache::put($config['token_cache_name'], $token, $config['token_cache_lifetime']);
            }
            $service->setToken($token);

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
