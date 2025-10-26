<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CleanupExpiredOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cleanup {--dry-run : Run without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired orders and restore car stock';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting order cleanup...');

        $today = Carbon::today();
        $dryRun = $this->option('dry-run');

        // Find expired orders (end_date < today)
        $expiredOrders = Order::active()
            ->where('end_date', '<', $today)
            ->with('car')
            ->get();

        if ($expiredOrders->isEmpty()) {
            $this->info('No expired orders found.');
            return self::SUCCESS;
        }

        $this->info("Found {$expiredOrders->count()} expired orders.");

        $cleaned = 0;
        $errors = 0;

        foreach ($expiredOrders as $order) {
            try {
                if ($dryRun) {
                    $this->line("Would clean order #{$order->id} - Car: {$order->car->name}");
                } else {
                    DB::transaction(function () use ($order) {
                        // Return stock to car
                        $order->car->incrementStock();

                        // Mark order as returned/completed
                        $order->update([
                            'status' => 'returned',
                        ]);

                        Log::info('Order auto-cleaned', [
                            'order_id' => $order->id,
                            'car_id' => $order->car_id,
                            'end_date' => $order->end_date->toDateString(),
                        ]);
                    });

                    $this->info("✓ Cleaned order #{$order->id}");
                }

                $cleaned++;
            } catch (\Exception $e) {
                $errors++;
                $this->error("✗ Failed to clean order #{$order->id}: {$e->getMessage()}");

                Log::error('Order cleanup failed', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->newLine();
        $this->info("Cleanup completed: {$cleaned} orders processed, {$errors} errors.");

        return self::SUCCESS;
    }
}
