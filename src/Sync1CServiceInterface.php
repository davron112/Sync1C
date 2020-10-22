<?php

namespace Davron112\Sync1C;

/**
 * Interface Sync1CServiceInterface
 * @package namespace Davron112\Sync1C;
 *
 * @method Services\OrderService         getOrderService()
 * @method Services\ContactService       getContactService()
 * @method Services\ProductService       getProductService()
 */
interface Sync1CServiceInterface
{
    /**
     * Set config
     *
     * @param array $config contain cofiguration variables
     */
    public function setConfig(array $config);
}
