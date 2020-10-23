<?php

namespace Davron112\Integration1c;

use Illuminate\Container\Container;
use Davron112\Integration1c\Traits\CredentialsTrait;
use Davron112\Integration1c\Services\RequestService;

/**
 * Class Integration1cService
 * @package namespace Davron112\Integration1c;
 *
 * @method Services\OrderService         getOrderService()
 * @method Services\ContactService       getContactService()
 * @method Services\ProductService getProductService()
 */
class Integration1cService implements Integration1cServiceInterface
{
    use CredentialsTrait;

    /**
     * A Request Service.
     *
     * @var RequestService
     */
    protected $requestService;

    /**
     * Config.
     *
     * @var array
     */
    private $config;

    /**
     * An authorization token.
     *
     * @var string auth token
     */
    protected $token;

    /**
     * Set a config
     *
     * @param array $config contain cofiguration variables
     *
     * @return void
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * Set a token
     *
     * @param string|null $token 1c-sync access token
     *
     * @return void
     */
    public function setToken(?string $token)
    {
        $this->token = $token;
    }

    /**
     * Constructor
     *
     * @param Container $container
     * @param RequestService $requestService
     *
     */
    public function __construct(Container $container, RequestService $requestService)
    {
        $this->container      = $container;
        $this->requestService = $requestService;
    }

    /**
     * Return a service
     *
     * @param string $name method name
     * @param string $value method value
     *
     * @return mixed
     */
    public function __call($name, $value)
    {
        $methods = [
            'getProductService',
            'getOrderService',
            'getContactService',
        ];
        if (in_array($name, $methods)) {
            return $this->getService(substr($name, 3));
        }

        throw new \Exception('Unable to find a service.');
    }

    /**
     * Get a service
     *
     * @param string $serviceName service name
     *
     * @return Davron112\Integration1c\Services\BaseService
     */
    private function getService(string $serviceName)
    {
        $propName = lcfirst($serviceName);
        if (empty($this->$propName)) {
            $service = $this->container->make('Davron112\Integration1c\Services\\'. $serviceName);
            $service->setRequestService($this->requestService);
            $service->setConfig($this->config);
            if (!empty($this->token)) {
                $service->setToken($this->token);
            }
            if ($this->credentials) {
                $service->setCredentials($this->credentials);
            } else {
                $service->setCredentials($this->config['auth']);
            }
            $this->$propName = $service;
        } else {
            $service = $this->$propName;
        }

        return $service;
    }
}