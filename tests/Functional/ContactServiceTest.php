<?php

namespace Davron112\Sync1C\Functional;

use GuzzleHttp\Handler\MockHandler;

/**
 * Class ContactServiceTest
 * @package namespace Davron112\Sync1C\Functional
 */
class ContactServiceTest extends BaseServiceClass
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
            self::getSuccessResponse(),
            self::getUnsuccessfulResponse(),
            self::getSuccessResponse(),
            self::getUnsuccessfulResponse(),
            self::getSuccessResponse(),
            self::getUnsuccessfulResponse(),
        ]);
        self::setUpService($mock);
    }

    /**
     * Get all companies
     *
     * @return void
     */
    public function testGetAll()
    {
        $this->assertInternalType('array', self::$service->getContactService()->getAll());
    }

    /**
     * Get by company id.
     *
     * @return void
     */
    public function testGetByCompany()
    {
        $this->assertInternalType('array', self::$service->getContactService()->getByCompany(time()));
    }

    /**
     * Get a company
     *
     * @return void
     */
    public function testGet()
    {
        $this->assertArrayHasKey('Name', self::$service->getContactService()->get('test-id'));
    }

    /**
     * Create a company
     *
     * @return void
     */
    public function testCreate()
    {
        $this->assertEquals(true, self::$service->getContactService()->create([
            "Address1"              => "Address 1",
            "Address2"              => "Address 2",
            "City"                  => "Malmo",
            "CompanyNo"             => "0001",
            "CompanyType"           => "advertiser",
            "ContactPersonEmail"    => "malmoadvert@gmail.com",
            "ContactPersonFullName" => "John Doe",
            "ContactPersonPhone"    => "5554455578",
            "Country"               => "Sweden",
            "ExternalId"            => 19,
            "Name"                  => 'Name ' . time(),
            "Zip"                   => "234234"
        ]));
        $this->assertEquals(false, self::$service->getContactService()->create([]));
        $this->assertEquals(1, self::$service->getContactService()->getStatusCode());
    }

    /**
     * Update a company
     *
     * @return void
     */
    public function testUpdate()
    {
        $this->assertEquals(true, self::$service->getContactService()->update([
            'Country'   => 'Sweden',
            'City'      => 'Stockholm',
            'Zip'       => '12345',
            'Address1'  => 'Line 1',
            'Address2'  => 'Line 2',
            'Name'      => 'Full Name',
            'Email'     => 'email@email.com',
            'Phone'     => '123467890',
            'CompanyId' => 1,
        ], 'test-id'));
        $this->assertEquals(false, self::$service->getContactService()->update([], ''));
        $this->assertEquals(1, self::$service->getContactService()->getStatusCode());
    }
}
