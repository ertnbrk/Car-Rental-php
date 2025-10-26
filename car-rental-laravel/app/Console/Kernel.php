<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Fetch FX rates every hour
        $schedule->command('fx:fetch')->hourly();

        // Clean up expired orders daily at 2 AM
        $schedule->command('orders:cleanup')->dailyAt('02:00');

        // Clear expired cache entries daily
        $schedule->command('cache:prune-stale-tags')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
