<?php

namespace Davron112\Integrations;

/**
 * Interface IntegrationserviceInterface
 * @package namespace Davron112\Integrations;
 *
 * @method Services\OrderService         getOrderService()
 * @method Services\ContactService       getContactService()
 * @method Services\ProductService       getProductService()
 */
interface IntegrationserviceInterface
{
    /**
     * Set config
     *
     * @param array $config contain cofiguration variables
     */
    public function setConfig(array $config);
}
