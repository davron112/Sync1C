<?php

namespace Davron112\Sync1C\Integrational;

use Davron112\Sync1C\Models\Response;

/**
 * Class ProductServiceTest
 * @package namespace Tests\Services\Sync1CService
 */
class ProductServiceTest extends BaseIntegrationalServiceClass
{
    /**
     * Get all products
     *
     * @return void
     */
    public function testGetAll()
    {
        self::printMessage('Product service test has been started');
        $service  = self::$service->getProductService();
        $response = $service->getAll();

        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('Id', end($response));
        $this->assertArrayHasKey('Name', end($response));
        $this->assertArrayHasKey('Category', end($response));
        $this->assertArrayHasKey('Category2', end($response));
        $this->assertArrayHasKey('CustomField', end($response));
        $this->assertArrayHasKey('SelectedProperties', end($response));
        $this->assertArrayHasKey('Comment', end($response));
        $this->assertArrayHasKey('Active', end($response));
        $this->assertArrayHasKey('Prices', end($response));
        $this->assertArrayHasKey('IsDeleted', end($response));
    }

    /**
     * Get updated products.
     *
     * @return void
     */
    public function testGetUpdated()
    {
        $service  = self::$service->getProductService();
        $response = $service->getUpdated(strtotime('today -5 year'));

        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('Id', end($response));
        $this->assertArrayHasKey('Name', end($response));
        $this->assertArrayHasKey('Category', end($response));
        $this->assertArrayHasKey('Category2', end($response));
        $this->assertArrayHasKey('CustomField', end($response));
        $this->assertArrayHasKey('SelectedProperties', end($response));
        $this->assertArrayHasKey('Comment', end($response));
        $this->assertArrayHasKey('Active', end($response));
        $this->assertArrayHasKey('Prices', end($response));
        $this->assertArrayHasKey('IsDeleted', end($response));

        $response = $service->getUpdated(strtotime('now +30 minutes'));
        $this->assertEquals(Response::ID_NOT_FOUND, $service->getStatusCode());//success
        $this->assertFalse($response);
    }

    /**
     * Get a product
     *
     * @return void
     */
    public function testGet()
    {
        $service  = self::$service->getProductService();
        $products = $service->getAll();//get products
        $response = $service->get(self::ID_PRODUCT);

        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('Id', $response);
        $this->assertArrayHasKey('Name', $response);
        $this->assertArrayHasKey('Category', $response);
        $this->assertArrayHasKey('Category2', $response);
        $this->assertArrayHasKey('SelectedProperties', $response);
        $this->assertArrayHasKey('creatives', $response['SelectedProperties'][0]);
        $this->assertArrayHasKey('id', $response['SelectedProperties'][0]['creatives'][0]);
        $this->assertArrayHasKey('name', $response['SelectedProperties'][0]['creatives'][0]);
        $this->assertArrayHasKey('Comment', $response);
        $this->assertArrayHasKey('Active', $response);
        $this->assertArrayHasKey('Prices', $response);
        $this->assertArrayHasKey('IsDeleted', $response);
        $this->assertArrayHasKey('CustomField', $response);
        $this->assertArrayHasKey('CostModel', $response['Prices'][0]);
        $this->assertArrayHasKey('Price', $response['Prices'][0]);
        $this->assertEquals(false, $service->get(00000000));
        $this->assertEquals(Response::ID_NOT_FOUND, $service->getStatusCode());//404
    }

    /**
     * Get all product creative templates
     *
     * @return void
     */
    public function testGetSelectedCreativeTemplates()
    {
        $service  = self::$service->getProductService();
        $product  = $service->get(self::ID_PRODUCT);
        $response = $service->getTemplates([$product['SelectedProperties'][0]['creatives'][0]['id']]);

        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('id', $response[0]);
        $this->assertArrayHasKey('name', $response[0]);
        $this->assertArrayHasKey('type', $response[0]);
        $this->assertArrayHasKey('description', $response[0]);
        $this->assertArrayHasKey('variables', $response[0]);
        $this->assertInternalType('array', $response[0]['variables']);
        $this->assertArrayHasKey('type', $response[0]['variables'][0]);
        $this->assertArrayHasKey('variable', $response[0]['variables'][0]);
    }

    /**
     * Get all product creative templates
     *
     * @return void
     */
    public function testGetAllCreativeTemplates()
    {
        $service  = self::$service->getProductService();
        $response = $service->getTemplates();

        $this->assertEquals(Response::ID_RESPONSE_SUCCESS, $service->getStatusCode());//success
        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('id', $response[0]);
        $this->assertArrayHasKey('name', $response[0]);
        $this->assertArrayHasKey('type', $response[0]);
        $this->assertArrayHasKey('description', $response[0]);
        $this->assertArrayHasKey('variables', $response[0]);
        $this->assertInternalType('array', $response[0]['variables']);
        $this->assertArrayHasKey('type', $response[0]['variables'][0]);
        $this->assertArrayHasKey('variable', $response[0]['variables'][0]);
    }
}
