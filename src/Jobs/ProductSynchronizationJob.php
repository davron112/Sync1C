<?php

namespace Davron112\Synchronizations\Jobs;

use Davron112\Synchronizations\SynchronizationServiceInterface;
use Davron112\Synchronizations\Services\ProductService;
use Davron112\Synchronizations\Jobs\Contracts\ProductSynchronizationJob as ProductSynchronizationInterface;

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
     * @param SynchronizationServiceInterface $service
     */
    public function __construct(SynchronizationServiceInterface $service)
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
