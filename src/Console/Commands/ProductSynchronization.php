<?php

namespace Davron112\Console\Commands;

use Illuminate\Log\Logger;
use Illuminate\Console\Command;
use Davron112\Sync1C\Sync1CServiceInterface;
use Davron112\Jobs\Contracts\ProductSynchronization as SynchronizationJob;

/**
 * Class ProductSynchronization
 * @package namespace Davron112\Synchronizations\Console\Commands
 */
class ProductSynchronization extends Command
{
    /**
     * Logger
     *
     * @var \Illuminate\Log\Logger
     */
    protected $log;

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
     * @var Sync1CServiceInterface
     */
    protected $Sync1CService;

    /**
     * ProductSynchronization constructor.
     *
     * @param Sync1CServiceInterface $service
     * @param Logger $log
     */
    public function __construct(Sync1CServiceInterface $service, Logger $log)
    {
        parent::__construct();

        $this->log             = $log;
        $this->Sync1CService = $service;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $job = app(SynchronizationJob::class, [$this->Sync1CService]);
        app('Illuminate\Bus\Dispatcher')->dispatch($job);
    }
}
