<?php

namespace Davron112\Synchronizations;

/**
 * Interface SynchronizationServiceInterface
 * @package namespace Davron112\Synchronizations;
 *
 * @method Services\OrderService         getOrderService()
 * @method Services\ContactService       getContactService()
 * @method Services\ProductService       getProductService()
 */
interface SynchronizationServiceInterface
{
    /**
     * Set config
     *
     * @param array $config contain cofiguration variables
     */
    public function setConfig(array $config);
}
