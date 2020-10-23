<?php

namespace Davron112\Synchronizations\Console\Commands;


use Illuminate\Console\Command;
use Davron112\Synchronizations\SynchronizationServiceInterface;
use Davron112\Synchronizations\Jobs\Contracts\ProductSynchronizationJob as SynchronizationJob;

/**
 * Class ProductSynchronization
 * @package namespace Davron112\Synchronizations\Console\Commands
 */
class ProductSynchronization extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '1c:product-synchronization:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update products.';

    /**
     * @var SynchronizationServiceInterface
     */
    protected $SynchronizationService;

    /**
     * ProductSynchronization constructor.
     *
     * @param SynchronizationServiceInterface $service
     */
    public function __construct(SynchronizationServiceInterface $service)
    {
        var_dump(21312312312);
        parent::__construct();
        $this->SynchronizationService = $service;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        var_dump(21312312312);

        $job = app(SynchronizationJob::class, [$this->SynchronizationService]);
        app('Illuminate\Bus\Dispatcher')->dispatch($job);
    }
}
