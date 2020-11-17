<?php

namespace Davron112\Integrations;

/**
 * Interface IntegrationServiceInterface
 * @package namespace Davron112\Integrations;
 *
 * @method Services\OrderService         getOrderService()
 * @method Services\ProductService       getProductService()
 */
interface IntegrationServiceInterface
{
    /**
     * Set config
     *
     * @param array $config contain cofiguration variables
     */
    public function setConfig(array $config);
}
