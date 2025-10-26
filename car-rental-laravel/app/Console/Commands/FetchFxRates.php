<?php

namespace App\Console\Commands;

use App\Services\Fx\FxService;
use Illuminate\Console\Command;

class FetchFxRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fx:fetch {--force : Force fetch even if cache is fresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch latest FX rates from TCMB and store in database';

    /**
     * Execute the console command.
     */
    public function handle(FxService $fxService): int
    {
        $this->info('Fetching FX rates from TCMB...');

        // Clear cache if force flag is set
        if ($this->option('force')) {
            $fxService->clearCache();
            $this->info('Cache cleared.');
        }

        // Fetch rates
        $rates = $fxService->fetchFromTCMB();

        if (!$rates) {
            $this->error('Failed to fetch FX rates from TCMB.');
            return self::FAILURE;
        }

        $this->info('Fetched ' . count($rates) . ' currency rates.');

        // Store rates
        if ($fxService->storeRates($rates)) {
            $this->info('FX rates stored successfully.');

            // Display rates
            $this->table(
                ['Currency', 'Rate (TRY)', 'Date'],
                collect($rates)->map(fn($rate) => [
                    $rate['currency_code'],
                    number_format($rate['rate'], 4),
                    $rate['rate_date']->format('Y-m-d'),
                ])
            );

            return self::SUCCESS;
        }

        $this->error('Failed to store FX rates.');
        return self::FAILURE;
    }
}
