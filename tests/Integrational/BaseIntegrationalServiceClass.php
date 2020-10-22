<?php

namespace Davron112\Sync1C\Integrational;

use PHPUnit\Framework\TestCase;
use Illuminate\Container\Container;

/**
 * Class BaseServiceClass
 * @package namespace Tests\Services\Sync1CService
 */
abstract class BaseIntegrationalServiceClass extends TestCase
{
    const ID_PRODUCT    = '011017120353_81357377789';
    const ID_ADVERTISER = 4459252202;
    const ID_AGENCY     = 4459232764;

    /**
     * BaEntity ID
     *
     * @var int
     */
    protected static $id;

    /**
     * Inventory service.
     *
     * @var \Davron112\Sync1C\Sync1CService
     */
    public static $service;

    /**
     * Set up a service
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        self::$service = self::setUpService();
    }

    /**
     * Set Up Guzzle Service
     *
     * @return void
     */
    protected static function setUpService(): \Davron112\Sync1C\Sync1CService
    {
        if (!empty(self::$service)) {
            return self::$service;
        }

        $container = new Container;
        $service   = $container->make('Davron112\Sync1C\Sync1CService');
        $service->setConfig([
            'base_url'         => getenv('1C-SYNC_BASE_URL'),
            'prefix'           => getenv('1C-SYNC_DEFAULT_PREFIX'),
            'show_errors_flag' => getenv('1C-SYNC_SHOW_HTTP_ERRORS'),
            'log_path'         => false,
        ]);
        $service->setCredentials([
            'user'     => getenv('1C-SYNC_USER'),
            'password' => getenv('1C-SYNC_PASSWORD')
        ]);

        self::$service = $service;

        return $service;
    }

    /**
     * Get default asset
     *
     * @param string $suffix asset name suffix
     *
     * @return string
     */
    protected static function getDefaultAsset($suffix = '300x250'): string
    {
        return require('asset' . $suffix . '.php');
    }

    /**
     * Print text message to console
     *
     * @param $message message that should be printed
     *
     * @return string
     */
    public static function printMessage($message): void
    {
        echo PHP_EOL . $message . ' (' . time() . ')' . PHP_EOL;
    }
}
