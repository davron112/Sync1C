<?php

namespace Davron112\Console\Commands;


use Illuminate\Console\Command;
use Davron112\Sync1C\Sync1CServiceInterface;
use Davron112\Jobs\Contracts\ProductSynchronization as SynchronizationJob;

/**
 * Class ProductSynchronization
 * @package namespace Davron112\Console\Commands
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
     * @var Sync1CServiceInterface
     */
    protected $Sync1CService;

    /**
     * ProductSynchronization constructor.
     *
     * @param Sync1CServiceInterface $service
     */
    public function __construct(Sync1CServiceInterface $service)
    {
        var_dump(21312312312);
        parent::__construct();
        $this->Sync1CService = $service;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        var_dump(21312312312);

        $job = app(SynchronizationJob::class, [$this->Sync1CService]);
        app('Illuminate\Bus\Dispatcher')->dispatch($job);
    }
}
