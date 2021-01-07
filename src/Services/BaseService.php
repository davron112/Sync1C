<?php

namespace Davron112\Integrations\Services;

use Davron112\Integrations\Traits\CredentialsTrait;

/**
 * Class BaseService
 * @package namespace Davron112\Integrations\Services;
 */
abstract class BaseService
{
    use CredentialsTrait;

    /**
     * Config.
     *
     * @var array
     */
    private $config;

    /**
     * Response from Integrations.
     *
     * @var array
     */
    private $response;

    /**
     * An authorization token.
     *
     * @var string auth token
     */
    protected $token;

    /**
     * A Request Service.
     *
     * @var RequestService
     */
    protected $requestService;

    /**
     * Set a config.
     *
     * @param array $config
     *
     * @return void
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
        $this->requestService->setConfig($config);
    }

    /**
     * Set a request service.
     *
     * @param RequestService $requestService
     *
     * @return void
     */
    public function __construct(RequestService $requestService)
    {
        $this->requestService = $requestService;
    }

    /**
     * Get a message.
     *
     * @return string|bool message
     */
    public function getMessage()
    {
        return !empty($this->response['message'])? $this->response['message'] : false;
    }

    /**
     * Get a status code.
     *
     * @return int|bool status code
     */
    public function getStatusCode()
    {
        return isset($this->response['code'])? $this->response['code'] : false;
    }

    /**
     * Get an "object" array from a request result.
     *
     * @param array $response request response
     *
     * @return mixed array|bool
     */
    protected function getObject($response)
    {
        $this->response = $response;
        return isset($response)? $response : false;
    }

    /**
     * Check a status of a response.
     *
     * @param array $response request response
     *
     * @return bool
     */
    protected function checkStatus($response)
    {
        $this->response = $response;
        return (isset($response['code']) && Response::ID_RESPONSE_SUCCESS === $response['code'])? true : false;
    }

    /**
     * Get a request URL.
     *
     * @param string $path
     *
     * @return string
     */
    protected function setQuery($params = [])
    {
        return !empty($params) ? '?' . http_build_query($params) : '';
    }
}
