<?php

namespace Davron112\Integration1c\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Davron112\Integration1c\Services\Traits\Logger;

/**
 * Class RequestService
 * @package namespace Davron112\Integration1c\Services;
 */
class RequestService
{
    use Logger;

    /**
     * Guzzle client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * A config array.
     *
     * @var array contains configuration variables
     */
    protected $config;

    /**
     * Response content.
     *
     * @var array
     */
    protected $responseContent;

    /**
     * Class constructor.
     *
     * @param \GuzzleHttp\Client $client
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Set a config.
     *
     * @param array $config contains configuration variables
     *
     * @return void
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * Set the last exception.
     *
     * @param \GuzzleHttp\Psr7\Response $response Guzzle response
     *
     * @return void
     */
    public function setResponseContent(Response $response)
    {
        $this->responseContent = $response;
    }

    /**
     * Obtain a response content.
     *
     * @param bool $json json flag
     *
     * @var mixed
     */
    public function obtainResponseContent($json = true)
    {
        if ($this->responseContent) {
            ini_set('error_reporting', E_ERROR);
            $content = $this->responseContent->getBody()->getContents();
            if (strlen($content) > 1) {
                if ($json) {
                    return json_decode($content);
                } else {
                    return $content;
                }
            }
        }

        return [];
    }

    /**
     * Makea a POST request.
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Guzzle\Psr7\Response
     */
    public function makePostRequest($url, $data = [], array $requestHeaders = [])
    {
        return $this->makeRequest('POST', $url, $data, $requestHeaders);
    }

    /**
     * Make a PUT request.
     *
     * @param $url
     * @param array $data
     * @param array $requestHeaders
     * @return array|\Guzzle\Psr7\Response
     */
    public function makePutRequest($url, array $data = [], array $requestHeaders = [])
    {
        return $this->makeRequest('PUT', $url, $data, $requestHeaders);
    }

    /**
     * Make a PATCH request.
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Guzzle\Psr7\Response
     */
    public function makePatchRequest($url, array $data = [], array $requestHeaders = [])
    {
        return $this->makeRequest('PATCH', $url, $data, $requestHeaders);
    }

    /**
     * Make a GET request.
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Guzzle\Psr7\Response
     */
    public function makeGetRequest($url, array $data = [], array $requestHeaders = [])
    {
        return $this->makeRequest('GET', $url, $data, $requestHeaders);
    }

    /**
     * Make a DELETE request.
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Guzzle\Psr7\Response
     */
    public function makeDeleteRequest($url, array $data = [], array $requestHeaders = [])
    {
        return $this->makeRequest('DELETE', $url, $data, $requestHeaders);
    }

    /**
     * Make a HTTP request.
     *
     * @param string $method HTTP method
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Guzzle\Psr7\Response
     */
    private function makeRequest($method, $url, $data, array $requestHeaders)
    {
        $defaultHeaders = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($this->config['auth']['user'] . ':' . $this->config['auth']['password'])
            ],
            'json'           => $data,
            'decode_content' => false,
            'http_errors'    => $this->config['show_errors_flag'],
        ];
        $fullUrl  = $this->config['base_url'] . $this->config['prefix'] . $url;

        $headers  = array_replace_recursive($defaultHeaders, $requestHeaders);
        $response = $this->client->request($method, $fullUrl, $headers, $data);

        $this->setResponseContent($response);
        //$this->log($this->config, $fullUrl, $method, $headers, $response);
        return $this->obtainResponseContent();
    }

    /**
     * Make a plane HTTP request.
     *
     * @param string $method HTTP method
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Guzzle\Psr7\Response
     */
    public function makePlaneRequest($method, $url, array $data = [], array $requestHeaders = [])
    {
        $defaultHeaders = [
            'json'           => $data,
            'decode_content' => false,
            'http_errors'    => $this->config['show_errors_flag'],
        ];
        $fullUrl  = $this->config['base_url'] . $url;
        $headers  = array_replace_recursive($defaultHeaders, $requestHeaders);
        $response = $this->client->request($method, $fullUrl, $headers, $data);

        $this->setResponseContent($response);
        //$this->log($this->config, $fullUrl, $method, $headers, $response);
        return $this->obtainResponseContent(false);
    }
}
