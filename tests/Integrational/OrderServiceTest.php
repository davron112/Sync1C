<?php

namespace Davron112\Sync1C\Integrational;

use Davron112\Sync1C\Models\Response;

/**
 * Class OrderServiceTest
 * @package namespace Tests\Services\Sync1CService
 */
class OrderServiceTest extends BaseIntegrationalServiceClass
{
    /**
     * Advertiser ID
     *
     * @var int
     */
    protected static $advertiserId;

    /**
     * Create an order
     *
     * @return void
     */
    public function testCreate()
    {
        self::printMessage('Order service test has been started');
        self::$advertiserId = self::ID_ADVERTISER;
        $service            = self::$service->getOrderService();
        $orderId            = $service->create([
            "ExternalId"   => time(),
            "Name"         => 'Name ' . time(),
            "Number"       => 4,
            "AdvertiserId" => self::$advertiserId,
            "AgencyId"     => self::ID_AGENCY,
            "Status"       => 'Active'
        ]);
        $this->assertInternalType('integer', $orderId);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
        self::$id = $orderId;
        $response = $service->create([
            "ExternalId"   => time(),
            "AdvertiserId" => self::$advertiserId,
            "AgencyId"     => self::ID_AGENCY,
            "Status"       => 'Active'
        ]);
        $this->assertEquals(false, $response);
        $this->assertEquals(Response::ID_VALIDATION_ERROR, $service->getStatusCode());//validation error
    }

    /**
     * Get all products
     *
     * @return void
     */
    public function testGetAll()
    {
        $service  = self::$service->getOrderService();
        $response = $service->getAll();

        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('Id', $response[0]);
        $this->assertArrayHasKey('ExternalId', $response[0]);
        $this->assertArrayHasKey('Name', $response[0]);
        $this->assertArrayHasKey('Number', $response[0]);
        $this->assertArrayHasKey('Status', $response[0]);
        $this->assertArrayHasKey('AdvertiserId', $response[0]);
        $this->assertArrayHasKey('AgencyId', $response[0]);
    }

    /**
     * Get updated orders.
     *
     * @return void
     */
    public function testGetUpdated()
    {
        $service  = self::$service->getOrderService();
        $response = $service->getUpdated(strtotime('today -1 minute'));

        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('Id', $response[0]);
        $this->assertArrayHasKey('ExternalId', $response[0]);
        $this->assertArrayHasKey('Name', $response[0]);
        $this->assertArrayHasKey('Number', $response[0]);
        $this->assertArrayHasKey('Status', $response[0]);
        $this->assertArrayHasKey('AdvertiserId', $response[0]);
        $this->assertArrayHasKey('AgencyId', $response[0]);

        $response = $service->getUpdated(strtotime('now +30 minutes'));
        $this->assertEquals(Response::ID_NOT_FOUND, $service->getStatusCode());//success
        $this->assertFalse($response);
    }

    /**
     * Update an order
     *
     * @return void
     */
    public function testUpdate()
    {
        $service  = self::$service->getOrderService();
        $response = $service->update([
            "ExternalId"   => time(),
            "Name"         => 'Name ' . time(),
            "Number"       => 5,
            "AdvertiserId" => self::$advertiserId,
            "AgencyId"     => self::ID_AGENCY,
            "Status"       => 'Active'
        ], self::$id);
        $this->assertEquals(true, $response);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
        $response = $service->update([
            "ExternalId"   => time() + 1,
            "Name"         => 'Name ' . time(),
            "Number"       => 5,
            "AdvertiserId" => self::$advertiserId,
            "AgencyId"     => self::ID_AGENCY,
            "Status"       => 'Active'
        ], 00000000);
        $this->assertEquals(false, $response);
        $this->assertEquals(Response::ID_NOT_FOUND, $service->getStatusCode());//404
        $response  = $service->update([
            "ExternalId"   => time() + 2,
            "AdvertiserId" => self::$advertiserId,
            "AgencyId"     => self::ID_AGENCY,
            "Status"       => 'Active'
        ], self::$id);
        $this->assertEquals(false, $response);
        $this->assertEquals(Response::ID_VALIDATION_ERROR, $service->getStatusCode());//validation error
    }

    /**
     * Approve an order
     *
     * @return void
     */
    public function testApprove()
    {
        $service  = self::$service->getOrderService();
        $response = $service->approve(self::$id);
        $this->assertEquals(true, $response);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
        $response = $service->approve(00000000);
        $this->assertEquals(false, $response);
        $this->assertEquals(Response::ID_NOT_FOUND, $service->getStatusCode());//404
    }

    /**
     * Pause an order
     *
     * @return void
     */
    public function testPause()
    {
        $service  = self::$service->getOrderService();
        $response = $service->pause(self::$id);
        $this->assertEquals(true, $response);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
        $response = $service->pause(00000000);
        $this->assertEquals(false, $response);
        $this->assertEquals(Response::ID_NOT_FOUND, $service->getStatusCode());//404
    }

    /**
     * Cancel an order
     *
     * @return void
     */
    public function testCancel()
    {
        $service  = self::$service->getOrderService();
        $response = $service->cancel(self::$id);
        $this->assertEquals(true, $response);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
        $response = $service->cancel(00000000);
        $this->assertEquals(false, $response);
        $this->assertEquals(Response::ID_NOT_FOUND, $service->getStatusCode());//404
    }

    /**
     * Archive an order
     *
     * @return void
     */
    public function testArchive()
    {
        $service = self::$service->getOrderService();
        $orderId = $service->create([
            "ExternalId"   => time(),
            "Name"         => 'Name ' . time(),
            "Number"       => 4,
            "AdvertiserId" => self::$advertiserId,
            "Status"       => 'Active'
        ]);
        $response = $service->archive($orderId);
        $this->assertEquals(true, $response);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
        $response = $service->archive(00000000);
        $this->assertEquals(false, $response);
        $this->assertEquals(Response::ID_NOT_FOUND, $service->getStatusCode());//404
        $service->delete($orderId);
    }

    /**
     * Delete an order
     *
     * @return void
     */
    public function testDelete()
    {
        $service  = self::$service->getOrderService();
        $response = $service->delete(self::$id);
        $this->assertEquals(true, $response);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
        $response = $service->delete(00000000);
        $this->assertEquals(false, $response);
        $this->assertEquals(Response::ID_NOT_FOUND, $service->getStatusCode());//404
    }
}
