<?php

namespace Davron112\Sync1C\Services;

use Davron112\Sync1C\Traits\CredentialsTrait;

/**
 * Class BaseService
 * @package namespace Davron112\Sync1C\Services;
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
     * Response from Sync1C.
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
    public function setRequestService(RequestService $requestService)
    {
        $this->requestService = $requestService;
    }

    /**
     * Set a token.
     *
     * @param string $token
     *
     * @return void
     */
    public function setToken(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get a message.
     *
     * @return string|bool message
     */
    public function getMessage()
    {
        return !empty($this->response['Message'])? $this->response['Message'] : false;
    }

    /**
     * Get a status code.
     *
     * @return int|bool status code
     */
    public function getStatusCode()
    {
        return isset($this->response['Code'])? $this->response['Code'] : false;
    }

    /**
     * Get request token from B4M.
     *
     * @return string|null
     */
    public function login(): ?string
    {
        $data = $this->requestService->makePostRequest('login', $this->credentials);
        if (!empty($data['Ticket'])) {
            return $data['Ticket'];
        }

        return null;
    }

    /**
     * Get an auth token.
     *
     * @return string
     */
    protected function getToken()
    {
        if (empty($this->token)) {
            $this->token = $this->login();
        }

        return $this->token;
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
     * Get an item ID.
     *
     * @param array $response
     *
     * @return mixed
     */
    protected function getObjectId($response)
    {
        if ($this->checkStatus($response)) {
            return isset($response['Object']['Id'])? intval($response['Object']['Id']) : false;
        }
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
        return (isset($response['Code']) && Response::ID_RESPONSE_SUCCESS === $response['Code'])? true : false;
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
