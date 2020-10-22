<?php

namespace Davron112\Sync1C\Functional;

use Illuminate\Log\Logger;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Container\Container;
use GuzzleHttp\Handler\MockHandler;
use Davron112\Sync1C\Models\ResponseStatus;

/**
 * Class BaseServiceClass
 * @package namespace Davron112\Sync1C\Functional
 */
abstract class BaseServiceClass extends \PHPUnit_Framework_TestCase
{
    /**
     * Sync1C service
     *
     * @var Davron112\Sync1C\Services\BaseService
     */
    protected static $service;

    /**
     * Set Up Guzzle Service
     *
     * @param GuzzleHttp\Handler\MockHandler $mock
     */
    protected static function setUpService(MockHandler $mock)
    {
        $handler   = HandlerStack::create($mock);
        $container = new Container;
        $service   = $container->make('Davron112\Sync1C\Sync1CService');
        $service->setConfig([
            'base_url'         => '',
            'prefix'           => '',
            'show_errors_flag' => false
        ]);
        $service->setCredentials([
            'user'     => '',
            'password' => '',
        ]);

        $requestservice = $container->make('Davron112\Sync1C\Services\RequestService');
        $reflection = new \ReflectionClass($requestservice);
        $reflection_property_client = $reflection->getProperty('client');
        $reflection_property_client->setAccessible(true);
        $reflection_property_client->setValue($requestservice, new Client(['handler' => $handler]));

        $reflection = new \ReflectionClass($service);
        $reflection_property_request_service = $reflection->getProperty('requestService');
        $reflection_property_request_service->setAccessible(true);
        $reflection_property_request_service->setValue($service, $requestservice);
        self::$service = $service;
    }

    /**
     * Get response with token
     *
     * @return GuzzleHttp\Psr7\Response
     */
    public static function getToken()
    {
        return self::getResponse(
            ResponseStatus::HTTP_OK,
            Psr7\stream_for('{"Ticket":"xxx"}')
        );
    }

    /**
     * Get response with success flag
     *
     * @return GuzzleHttp\Psr7\Response
     */
    public static function getSuccessResponse()
    {
        return self::getResponse(
            ResponseStatus::HTTP_OK,
            Psr7\stream_for('{"Result":"ok","Code":0,"Object":{"Name":"test","Id":123}}')
        );
    }

    /**
     * Get response with object
     *
     * @return GuzzleHttp\Psr7\Response
     */
    public static function getSuccessResponseWithObject()
    {
        return self::getResponse(
            ResponseStatus::HTTP_OK,
            Psr7\stream_for(
                '{"Result":"ok","Message":"All companies","Code":0,"Object":{"Name":null,"id":1}}'
            )
        );
    }

    /**
     * Get response with integer
     *
     * @return GuzzleHttp\Psr7\Response
     */
    public static function getSuccessResponseWithInteger()
    {
        return self::getResponse(
            ResponseStatus::HTTP_OK,
            Psr7\stream_for(
                '{"Result":"ok","Message":"report job has started","Code":0,"Object":2069118181}'
            )
        );
    }

    /**
     * Get response with string
     *
     * @return GuzzleHttp\Psr7\Response
     */
    public static function getSuccessResponseWithString()
    {
        return self::getResponse(
            ResponseStatus::HTTP_OK,
            Psr7\stream_for(
                'Dimension.LINE_ITEM_ID,Dimension.ORDER_ID,Dimension.DATE'
            )
        );
    }

    /**
     * Get unsuccessful response
     *
     * @return GuzzleHttp\Psr7\Response
     */
    public static function getUnsuccessfulResponse()
    {
        return self::getResponse(
            ResponseStatus::HTTP_OK,
            Psr7\stream_for('{"Result":"error","Message":"Generic error.","Code":1,"Object":null}')
        );
    }

    /**
     * Get response with array of objects
     *
     * @return GuzzleHttp\Psr7\Response
     */
    public static function getSuccessResponseWithArrayObjects()
    {
        return self::getResponse(
            ResponseStatus::HTTP_OK,
            Psr7\stream_for('{"Result":"ok","Message":"All companies","Code":0,"Object":[]}')
        );
    }

    /**
     * Set Up Guzzle Service
     *
     * @param GuzzleHttp\Handler\MockHandler $mock
     * @param string $content response content
     *
     * @return GuzzleHttp\Psr7\Response
     */
    public static function getResponse($status, $content = false)
    {
        return new Response($status, ['Content-Type' => 'application/json'], $content);
    }
}
