<?php

namespace Davron112\Sync1C\Functional;

use GuzzleHttp\Handler\MockHandler;

/**
 * Class OrderServiceTest
 * @package namespace Davron112\Sync1C\Functional
 */
class OrderServiceTest extends BaseServiceClass
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
            self::getSuccessResponse(),
            self::getUnsuccessfulResponse(),
            self::getSuccessResponse(),
            self::getUnsuccessfulResponse(),
            self::getSuccessResponse(),
            self::getUnsuccessfulResponse(),
            self::getSuccessResponse(),
            self::getUnsuccessfulResponse(),
            self::getSuccessResponse(),
            self::getUnsuccessfulResponse(),
            self::getSuccessResponse(),
            self::getUnsuccessfulResponse(),
            self::getSuccessResponse(),
            self::getUnsuccessfulResponse(),
            self::getSuccessResponseWithArrayObjects(),
            self::getSuccessResponseWithArrayObjects(),
        ]);
        self::setUpService($mock);
    }

    /**
     * Create a order
     *
     * @return void
     */
    public function testCreate()
    {
        $this->assertEquals(true, self::$service->getOrderService()->create([
            'ExternalId' => 'test-id',
            'Name'       => 'Testname',
            'Number'     => '188',
            'Status'     => 'Active',
        ]));

        $this->assertEquals(false, self::$service->getOrderService()->create([]));
        $this->assertEquals(1, self::$service->getOrderService()->getStatusCode());
    }

    /**
     * Update a order
     *
     * @return void
     */
    public function testUpdate()
    {
        $this->assertEquals(true, self::$service->getOrderService()->update([
            'id'         => 'test-id',
            'ExternalId' => 'test-id',
            'Name'       => 'Testname',
            'Number'     => '188',
            'Status'     => 'Active',
        ], 'test-id'));

        $this->assertEquals(false, self::$service->getOrderService()->update([], ''));
        $this->assertEquals(1, self::$service->getOrderService()->getStatusCode());
    }

    /**
     * Delete a order
     *
     * @return void
     */
    public function testDelete()
    {
        $this->assertEquals(true, self::$service->getOrderService()->delete('test-id'));
        $this->assertEquals(false, self::$service->getOrderService()->delete('test-id'));
        $this->assertEquals(1, self::$service->getOrderService()->getStatusCode());
    }

    /**
     * Test order approvement
     *
     * @return void
     */
    public function testApprove()
    {
        $this->assertEquals(true, self::$service->getOrderService()->approve('test-id'));
        $this->assertEquals(false, self::$service->getOrderService()->approve(''));
        $this->assertEquals(1, self::$service->getOrderService()->getStatusCode());
    }

    /**
     * Test order pause
     *
     * @return void
     */
    public function testPause()
    {
        $this->assertEquals(true, self::$service->getOrderService()->pause('test-id'));
        $this->assertEquals(false, self::$service->getOrderService()->pause(''));
        $this->assertEquals(1, self::$service->getOrderService()->getStatusCode());
    }

    /**
     * Test order cancellation
     *
     * @return void
     */
    public function testCancel()
    {
        $this->assertEquals(true, self::$service->getOrderService()->cancel('test-id'));
        $this->assertEquals(false, self::$service->getOrderService()->cancel(''));
        $this->assertEquals(1, self::$service->getOrderService()->getStatusCode());
    }

    /**
     * Test order archiving
     *
     * @return void
     */
    public function testArchive()
    {
        $this->assertEquals(true, self::$service->getOrderService()->archive('test-id'));
        $this->assertEquals(false, self::$service->getOrderService()->archive(''));
        $this->assertEquals(1, self::$service->getOrderService()->getStatusCode());
    }

    /**
     * Get all orders
     *
     * @return void
     */
    public function testGetAll()
    {
        $this->assertInternalType('array', self::$service->getOrderService()->getAll());
    }

    /**
     * Get updated orders.
     *
     * @return void
     */
    public function testGetUpdated()
    {
        $this->assertInternalType('array', self::$service->getOrderService()->getUpdated(time()));
    }
}
