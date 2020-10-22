<?php

namespace Davron112\Sync1C\Integrational;

use Davron112\Sync1C\Models\Response;

/**
 * Class ContactServiceTest
 * @package namespace Tests\Services\Sync1CService
 */
class ContactServiceTest extends BaseIntegrationalServiceClass
{
    /**
     * Contact ID
     *
     * @var int
     */
    public static $contactId;

    /**
     * Company ID
     *
     * @var int
     */
    public static $companyId;

    /**
     * Create a contact
     *
     * @return void
     */
    public function testCreate()
    {
        $companyId = self::$service->getCompanyService()->create([
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
        ]);
        $service   = self::$service->getContactService();
        $contactId = $service->create([
            'Country'   => 'Sweden',
            'City'      => 'Stockholm',
            'Zip'       => '12345',
            'Address1'  => 'Line 1',
            'Address2'  => 'Line 2',
            'Name'      => 'Full Name',
            'Email'     => 'email@email.com',
            'Phone'     => '123467890',
            'CompanyId' => $companyId,
        ]);

        self::$companyId = $companyId;
        self::$contactId = $contactId;
        $this->assertInternalType('integer', $contactId);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
    }

    /**
     * Update a contact
     *
     * @return void
     */
    public function testUpdate()
    {
        $service  = self::$service->getContactService();
        $response = $service->update([
            'Country'   => 'Sweden',
            'City'      => 'Stockholm',
            'Zip'       => '12345',
            'Address1'  => 'Line 1',
            'Address2'  => 'Line 2',
            'Name'      => 'Full Name',
            'Email'     => 'email@email.com',
            'Phone'     => '123467890',
            'CompanyId' => self::$companyId,
        ], self::$contactId);

        $this->assertEquals(true, $response);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
    }

    /**
     * Get a contact by ID.
     *
     * @return void
     */
    public function testGet()
    {
        $service  = self::$service->getContactService();
        $response = $service->get(self::$contactId);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('Country', $response);
        $this->assertArrayHasKey('City', $response);
        $this->assertArrayHasKey('Zip', $response);
        $this->assertArrayHasKey('Address1', $response);
        $this->assertArrayHasKey('Address2', $response);
        $this->assertArrayHasKey('Name', $response);
        $this->assertArrayHasKey('Email', $response);
        $this->assertArrayHasKey('Phone', $response);
        $this->assertArrayHasKey('CompanyId', $response);

        $response = $service->get(0);
        $this->assertEquals(Response::ID_NOT_FOUND, $service->getStatusCode());
        $this->assertFalse($response);
    }

    /**
     * Get a contact by company ID.
     *
     * @return void
     */
    public function testGetByCompany()
    {
        $service  = self::$service->getContactService();
        $response = $service->getByCompany(self::$companyId);
        $this->assertInternalType('array', $response[0]);
        $this->assertArrayHasKey('Country', $response[0]);
        $this->assertArrayHasKey('City', $response[0]);
        $this->assertArrayHasKey('Zip', $response[0]);
        $this->assertArrayHasKey('Address1', $response[0]);
        $this->assertArrayHasKey('Address2', $response[0]);
        $this->assertArrayHasKey('Name', $response[0]);
        $this->assertArrayHasKey('Email', $response[0]);
        $this->assertArrayHasKey('Phone', $response[0]);
        $this->assertArrayHasKey('CompanyId', $response[0]);
    }

    /**
     * Get all companies.
     *
     * @return void
     */
    public function testGetAll()
    {
        $service  = self::$service->getContactService();
        $response = $service->getAll();
        $this->assertInternalType('array', $response[0]);
        $this->assertArrayHasKey('Country', $response[0]);
        $this->assertArrayHasKey('City', $response[0]);
        $this->assertArrayHasKey('Zip', $response[0]);
        $this->assertArrayHasKey('Address1', $response[0]);
        $this->assertArrayHasKey('Address2', $response[0]);
        $this->assertArrayHasKey('Name', $response[0]);
        $this->assertArrayHasKey('Email', $response[0]);
        $this->assertArrayHasKey('Phone', $response[0]);
        $this->assertArrayHasKey('CompanyId', $response[0]);
    }
}
