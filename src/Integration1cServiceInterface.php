<?php

namespace Davron112\Integration1c;

/**
 * Interface Integration1cServiceInterface
 * @package namespace Davron112\Integration1c;
 *
 * @method Services\OrderService         getOrderService()
 * @method Services\ContactService       getContactService()
 * @method Services\ProductService       getProductService()
 */
interface Integration1cServiceInterface
{
    /**
     * Set config
     *
     * @param array $config contain cofiguration variables
     */
    public function setConfig(array $config);
}
