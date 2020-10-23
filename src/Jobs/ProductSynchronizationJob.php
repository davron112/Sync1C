<?php

namespace Davron112\Jobs;

use Davron112\Sync1C\Sync1CServiceInterface;
use Davron112\Sync1C\Services\ProductService;
use Davron112\Jobs\Contracts\ProductSynchronization as ProductSynchronizationInterface;

/**
 * Class ProductSynchronizationJob
 * @package namespace Davron112\Synchronizations\Jobs
 */
class ProductSynchronizationJob extends BaseSynchronization implements ProductSynchronizationInterface
{
    /**
     * Product Service
     *
     * @var ProductService
     */
    protected $service;

    /**
     * Last sync timestamp.
     *
     * @var mixed
     */
    protected $lastSync = null;

    /**
     * Constructor.
     *
     * ProductSynchronization constructor.
     *
     * @param Sync1CServiceInterface $service
     */
    public function __construct(Sync1CServiceInterface $service)
    {
        $this->service = $service->getProductService();
    }

    /**
     * Handler.
     */
    public function handle() {
        print_f(222);
    }
}
