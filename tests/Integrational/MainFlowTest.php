<?php

namespace Davron112\Sync1C\Integrational;

use Davron112\Sync1C\Models\Response;

/**
 * Class MainFlowTest
 * @package namespace Tests\Services\Sync1CService
 */
class MainFlowTest extends BaseIntegrationalServiceClass
{
    public static $companyId;
    public static $orderId;
    public static $campaignService;
    public static $campaignId;
    public static $productId;

    /**
     * Test company creation
     *
     * @return void
     */
    public function testCreateCompany()
    {
        self::printMessage('Flow test has been started');

        //create a new company
        self::$companyId = self::$service->getCompanyService()->create([
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

        self::printMessage('New company was created');
    }

    /**
     * Test order creation
     *
     * @return void
     */
    public function testCreateOrder()
    {
        //create a new order
        self::$orderId      = self::$service->getOrderService()->create([
            "ExternalId"   => time(),
            "Name"         => 'Name ' . time(),
            "Number"       => 4,
            "AdvertiserId" => self::$companyId,
            "Status"       => 'Active'
        ]);

        self::printMessage('New order was created');
    }

    /**
     * Check inventory availability
     *
     * @return void
     */
    public function testGetInventory()
    {
        $product         = self::$service->getProductService()->get(self::ID_PRODUCT);//get a product
        $service         = self::$service->getInventoryService();
        self::$productId = $product['Id'];
        $response        = $service->getByDate(
            self::$productId,
            date('Y-m-d', strtotime('+1 day')),
            date('Y-m-d', strtotime('+1 year')),
            1
        );
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('Available', $response);
        $this->assertArrayHasKey('Booked', $response);
        $this->assertArrayHasKey('Total', $response);

        self::printMessage('Product availability was checked');
    }

    /**
     * Test campaign creation
     *
     * @return void
     */
    public function testCreateCampaign()
    {
        //create a  new campaign
        self::$campaignService = self::$service->getCampaignService();
        $name          = 'Test name ' . time();
        $data          = [
            'Price'        => '123.4',
            'name'         => $name,
            'ProductId'    => self::$productId,
            'OrderId'      => self::$orderId,
            'StartDate'    => date('Y-m-d', strtotime('+1 day')),
            'EndDate'      => date('Y-m-d', strtotime('+1 year')),
            'Quantity'     => 1,
            'Status'       => 'Active',
            'ExternalId'   => time(),
            'GeoTargeting' => [
                [
                    'Id' => 2818
                ]
            ],
            'FrequencyCapping' => [
                'NumberOfUnits' => 12,
                'Impressions'   => 12,
                'Period'        => 'Hours',
            ],
            'Periods' => [
                [
                    'DayOfWeek'  => 'Monday',
                    'TimeRanges' => [
                        [
                            'StartTime' => "00:00",
                            'EndTime'   => "03:00",
                        ]
                    ]
                ],
            ],
        ];

        self::$campaignId = self::$campaignService->create($data);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, self::$campaignService->getStatusCode());
        $campaign = self::$campaignService->get(self::$campaignId);
        $this->assertArrayHasKey('ProductId', $campaign);
        $this->assertArrayHasKey('Price', $campaign);
        $this->assertArrayHasKey('Name', $campaign);
        $this->assertArrayHasKey('OrderId', $campaign);
        $this->assertArrayHasKey('StartDate', $campaign);
        $this->assertArrayHasKey('EndDate', $campaign);
        $this->assertArrayHasKey('Status', $campaign);
        $this->assertArrayHasKey('Quantity', $campaign);
        $this->assertArrayHasKey('ExternalId', $campaign);
        $this->assertArrayHasKey('Id', $campaign);
        $this->assertArrayHasKey('GeoTargeting', $campaign);
        $this->assertInternalType('array', $campaign['GeoTargeting']);
        $this->assertEquals($data['GeoTargeting'][0]['Id'], $campaign['GeoTargeting'][0]['Id']);
        $this->assertArrayHasKey('FrequencyCapping', $campaign);
        $this->assertInternalType('array', $campaign['FrequencyCapping']);
        $this->assertArrayHasKey('NumberOfUnits', $campaign['FrequencyCapping']);
        $this->assertArrayHasKey('Impressions', $campaign['FrequencyCapping']);
        $this->assertArrayHasKey('Period', $campaign['FrequencyCapping']);
        $this->assertEquals('Hours', $campaign['FrequencyCapping']['Period']);
        $this->assertEquals(12, $campaign['FrequencyCapping']['Impressions']);
        $this->assertEquals(12, $campaign['FrequencyCapping']['NumberOfUnits']);
        $this->assertArrayHasKey('Periods', $campaign);
        $this->assertInternalType('array', $campaign['Periods']);
        $this->assertArrayHasKey('DayOfWeek', $campaign['Periods'][0]);
        $this->assertArrayHasKey('TimeRanges', $campaign['Periods'][0]);
        $this->assertEquals('Monday', $campaign['Periods'][0]['DayOfWeek']);
        $this->assertArrayHasKey('StartTime', $campaign['Periods'][0]['TimeRanges'][0]);
        $this->assertEquals('00:00', $campaign['Periods'][0]['TimeRanges'][0]['StartTime']);
        $this->assertArrayHasKey('EndTime', $campaign['Periods'][0]['TimeRanges'][0]);
        $this->assertEquals('03:00', $campaign['Periods'][0]['TimeRanges'][0]['EndTime']);

        self::printMessage('New campaign was created');
    }

    /**
     * Get information about campaign inventory
     *
     * @return void
     */
    public function testGetInventoryForCampaign()
    {
        $service  = self::$service->getInventoryService();
        $response = $service->get(self::$campaignId);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('Available', $response);
        $this->assertArrayHasKey('Booked', $response);
        $this->assertArrayHasKey('Total', $response);

        self::printMessage('Information about campaign inventory was received');
    }

    /**
     * Update a campaign
     *
     * @return void
     */
    public function testUpdateCampaign()
    {
        //create a new campaign name
        $updatedName = 'Test name ' . time();
        $service     = self::$service->getCampaignService();
        $data        = [
            'Price'      => '144.8',
            'name'       => $updatedName,
            'ProductId'  => self::$productId,
            'OrderId'    => self::$orderId,
            'StartDate'  => date('Y-m-d', strtotime('+1 day')),
            'EndDate'    => date('Y-m-d', strtotime('+1 year')),
            'Quantity'   => 1,
            'Status'     => 'Active',
            'ExternalId' => time(),
            'GeoTargeting' => [
                [
                    'Id' => 2418
                ]
            ],
            'FrequencyCapping' => [
                'NumberOfUnits' => 1,
                'Impressions'   => 9,
                'Period'        => 'Days',
            ],
            'Periods' => [
                [
                    'DayOfWeek'  => 'Tuesday',
                    'TimeRanges' => [
                        [
                            'StartTime' => "01:00",
                            'EndTime'   => "02:00",
                        ]
                    ]
                ],
            ],
        ];
        $response = $service->update($data, self::$campaignId);
        $this->assertEquals(true, $response);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, self::$campaignService->getStatusCode());//success
        $campaign = self::$campaignService->get(self::$campaignId);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, self::$campaignService->getStatusCode());
        $this->assertArrayHasKey('ProductId', $campaign);
        $this->assertArrayHasKey('Name', $campaign);
        $this->assertArrayHasKey('OrderId', $campaign);
        $this->assertArrayHasKey('StartDate', $campaign);
        $this->assertArrayHasKey('EndDate', $campaign);
        $this->assertArrayHasKey('Status', $campaign);
        $this->assertArrayHasKey('Quantity', $campaign);
        $this->assertArrayHasKey('ExternalId', $campaign);
        $this->assertArrayHasKey('Id', $campaign);
        $this->assertArrayHasKey('GeoTargeting', $campaign);
        $this->assertInternalType('array', $campaign['GeoTargeting']);
        $this->assertEquals($data['GeoTargeting'][0]['Id'], $campaign['GeoTargeting'][0]['Id']);
        $this->assertArrayHasKey('FrequencyCapping', $campaign);
        $this->assertArrayHasKey('NumberOfUnits', $campaign['FrequencyCapping']);
        $this->assertArrayHasKey('Impressions', $campaign['FrequencyCapping']);
        $this->assertEquals(9, $campaign['FrequencyCapping']['Impressions']);
        $this->assertArrayHasKey('Period', $campaign['FrequencyCapping']);
        $this->assertEquals('Days', $campaign['FrequencyCapping']['Period']);
        $this->assertEquals(9, $campaign['FrequencyCapping']['Impressions']);
        $this->assertEquals(1, $campaign['FrequencyCapping']['NumberOfUnits']);
        $this->assertArrayHasKey('Periods', $campaign);
        $this->assertArrayHasKey('DayOfWeek', $campaign['Periods'][0]);
        $this->assertEquals('Tuesday', $campaign['Periods'][0]['DayOfWeek']);
        $this->assertArrayHasKey('StartTime', $campaign['Periods'][0]['TimeRanges'][0]);
        $this->assertEquals('01:00', $campaign['Periods'][0]['TimeRanges'][0]['StartTime']);
        $this->assertArrayHasKey('EndTime', $campaign['Periods'][0]['TimeRanges'][0]);
        $this->assertEquals('02:00', $campaign['Periods'][0]['TimeRanges'][0]['EndTime']);
        $this->assertArrayHasKey('TimeRanges', $campaign['Periods'][0]);

        self::printMessage('A campaign was updated');
    }

    /**
     * Test creative upload
     *
     * @return void
     */
    public function testCreativeUpload()
    {
        //create a creative to make campaign activation possible
        $creativeService = self::$service->getCreativeService();
        $response        = $creativeService->create([
            'CampaignId' => self::$campaignId,
            'ExternalId' => time(),
            'Type'       => 'image',
            'Url'        => 'http://google.com',
            'Name'       => 'Name ' . time(),
            'Filename'   => 'test.png',
            'Status'     => 'ACTIVE',
            'Asset'      => self::getDefaultAsset(),
            'Size' => [
                'Width'  => 300,
                'Height' => 250,
            ],
        ]);

        $this->assertEquals(true, $response);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $creativeService->getStatusCode());

        self::printMessage('A new creative was uploaded');
    }

    /**
     * Test order approvement
     *
     * @return void
     */
    public function testOrderApprovement()
    {
        $orderService = self::$service->getOrderService();
        //approve an order to make campaign activation possible
        $response     = $orderService->approve(self::$orderId);
        $this->assertEquals(true, $response);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $orderService->getStatusCode());

        self::printMessage('An order was approved');
    }

    /**
     * Test campaign activation
     *
     * @return void
     */
    public function testCampaignActivation()
    {
        //activate an campaign
        $response = self::$campaignService->activate(self::$campaignId);
        $this->assertEquals(true, $response);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, self::$campaignService->getStatusCode());
        self::printMessage('A campaign was activated');
    }

    /**
     * Test campaign pause
     *
     * @return void
     */
    public function testCampaignPause()
    {
        //pause a campaign
        $response = self::$campaignService->pause(self::$campaignId);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, self::$campaignService->getStatusCode());
        $campaign = self::$campaignService->get(self::$campaignId);
        $this->assertEquals('PAUSED', $campaign['Status']);
        self::printMessage('A campaign was paused');
    }

    /**
     * Test campaign resume
     *
     * @return void
     */
    public function testResumeCampaign()
    {
        //resume a campaign
        $response = self::$campaignService->resume(self::$campaignId);
        $this->assertEquals(true, $response);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, self::$campaignService->getStatusCode());
        $campaign = self::$campaignService->get(self::$campaignId);
        $this->assertEquals('READY', $campaign['Status']);
        self::printMessage('A campaign was resumed');
    }

    /**
     * Test campaign cancellation
     *
     * @return void
     */
    public function testCancelCampaign()
    {
        //cancel a campaign
        $response = self::$campaignService->cancel(self::$campaignId);
        $this->assertEquals(true, $response);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, self::$campaignService->getStatusCode());
        $campaign = self::$campaignService->get(self::$campaignId);
        $this->assertEquals('PAUSED_INVENTORY_RELEASED', $campaign['Status']);
        self::printMessage('A campaign was cancelled');
    }

    /**
     * Test statistics
     *
     * @return void
     */
    public function testGetStatistics()
    {
        //get statistics for a campaign
        $response = self::$campaignService->getStatistics(self::$campaignId);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, self::$campaignService->getStatusCode());
        $this->assertArrayHasKey('Delivered', $response);
        $this->assertArrayHasKey('CampaignId', $response);
        $this->assertArrayHasKey('Status', $response);
        $this->assertArrayHasKey('DeliveredPercentage', $response);
        $this->assertArrayHasKey('Clicks', $response);
        $this->assertArrayHasKey('CTR', $response);
        self::printMessage('Statistics was received');
    }

    /**
     * Test campaign delete attempt
     *
     * @return void
     */
    public function testDeleteCampaign()
    {
        //delete a campaign
        $response = self::$campaignService->delete(self::$campaignId);
        $this->assertEquals(true, $response);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, self::$campaignService->getStatusCode());
        $this->assertFalse(self::$campaignService->get(self::$campaignId));

        self::printMessage('A campaign was deleted');
    }

    /**
     * Test order delete attempt
     *
     * @return void
     */
    public function testDeleteOrder()
    {
        //delete an order
        $orderService = self::$service->getOrderService();
        $response     = $orderService->delete(self::$orderId);
        $this->assertEquals(true, $response);
        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $orderService->getStatusCode());

        self::printMessage('An order was deleted');

        self::printMessage('Flow test is completed');
    }
}
