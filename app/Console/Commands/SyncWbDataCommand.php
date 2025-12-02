<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SyncOrdersService;
use App\Services\SyncSalesService;
use App\Services\SyncIncomesService;
use App\Services\SyncStocksService;
use Carbon\Carbon;

class SyncWbDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     * type = (Orders||Sales||Incomes||Stocks, иначе All)
     *
     * @var string
     */
    protected $signature = 'app:sync {type?} {--from=} {--to=}';

    /**
     * О чем это?
     *
     * @var string
     */
    protected $description = 'Sync data from Wb Api';

    /**
     * Маппинг где каждый тип (ключ со значением класса) использует свой класс - вроде объяснил
     */
    protected array $services = [
        'orders' => SyncOrdersService::class,
        'sales' => SyncSalesService::class,
        'incomes' => SyncIncomesService::class,
        'stocks' => SyncStocksService::class,
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $type = $this->argument('type') ?? 'all';

        [$from, $to] = $this->determineDateRange();

        $this->info("Sync {$type} from {$from->format('Y-m-d')} to {$to->format('Y-m-d')}");
        $this->newLine();

            try {
            $typesToSync = $this->getTypesToSync($type);

            if (empty($typesToSync)) {
                $this->error("Unknown type: {$type}");
                $this->info("Available types: " . implode(', ', array_keys($this->services)) . ", all");
                return Command::FAILURE;
            }

            $results = [];
            foreach ($typesToSync as $syncType) {
                $results[$syncType] = $this->syncType($syncType, $from, $to);
                
                if ($syncType !== array_key_last($typesToSync)) {
                    $this->newLine();
                }
            }

            $this->newLine();
            $this->displayResults($results);
            $this->info('Synchronization completed successfully');

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Sync failed: ' . $e->getMessage());
            
            if ($this->output->isVerbose()) {
                $this->error($e->getTraceAsString());
            } else {
                $this->info('Run with -v flag');
            }
            
            return Command::FAILURE;
        }
    }

    protected function determineDateRange(): array
    {
        if ($this->option('from') && $this->option('to')) {
            $from = Carbon::parse($this->option('from'));
            $to = Carbon::parse($this->option('to'));
        } else {
            $from = now()->subDays(3);
            $to = now();
        }

        return [$from, $to];
    }

    protected function getTypesToSync(string $type): array
    {
        if ($type === 'all') {
            return array_keys($this->services);
        }

        if (isset($this->services[$type])) {
            return [$type];
        }

        return [];
    }

    protected function syncType(string $type, Carbon $from, Carbon $to): int
    {
        $serviceClass = $this->services[$type];
        $service = app($serviceClass);
        $label = ucfirst($type);

        $this->info("Синькааем {$label}...");
        
        $startTime = microtime(true);
        $service->sync($from, $to);
        $duration = round(microtime(true) - $startTime, 2);

        $count = $this->getRecordCount($type, $from, $to);
        
        $this->info("{$label} synced: {$count} records in {$duration}s");

        return $count;
    }

    protected function getRecordCount(string $type, Carbon $from, Carbon $to): int
    {
        $modelMap = [
            'orders' => \App\Models\Order::class,
            'sales' => \App\Models\Sale::class,
            'incomes' => \App\Models\Income::class,
            'stocks' => \App\Models\Stock::class,
        ];

        if (!isset($modelMap[$type])) {
            return 0;
        }

        $model = $modelMap[$type];
        
        if ($type === 'stocks') {
            return $model::whereDate('date', $to)->count();
        }
        return $model::whereBetween('date', [$from, $to])->count();
    }

    protected function displayResults(array $results): void
    {
        $this->info('Synchronization Summary:');
        
        $tableData = collect($results)->map(function ($count, $type) {
            return [
                ucfirst($type),
                number_format($count),
            ];
        })->toArray();

        $this->table(['Type', 'Records'], $tableData);

        $total = array_sum($results);
        $this->info("Total records: " . number_format($total));
    }
}