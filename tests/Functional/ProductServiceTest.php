<?php

namespace Davron112\Sync1C\Functional;

use GuzzleHttp\Handler\MockHandler;

/**
 * Class ProductServiceTest
 * @package namespace Davron112\Sync1C\Functional
 */
class ProductServiceTest extends BaseServiceClass
{
    /**
     * Set Up a Client
     *
     * @return void
     */
    public static function setUpBeforeClass()
    {
        $mock = new MockHandler([
            self::getToken(),
            self::getSuccessResponseWithArrayObjects(),
            self::getSuccessResponseWithArrayObjects(),
            self::getSuccessResponseWithObject(),
        ]);
        self::setUpService($mock);
    }

    /**
     * Get all products
     *
     * @return void
     */
    public function testGetAll()
    {
        $this->assertInternalType('array', self::$service->getProductService()->getAll());
    }

    /**
     * Get updated products.
     *
     * @return void
     */
    public function testGetUpdated()
    {
        $this->assertInternalType('array', self::$service->getProductService()->getUpdated(time()));
    }

    /**
     * Get a product
     *
     * @return void
     */
    public function testGet()
    {
        $this->assertArrayHasKey('Name', self::$service->getProductService()->get('test-id'));
    }
}
