<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Koperasi;
use App\Models\SubscriptionPackage;
use Carbon\Carbon;

class CheckSubscriptionExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'saas:check-subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check expired subscriptions and downgrade to free tier or expire';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking expired subscriptions...');

        $expiredKoperasis = Koperasi::where('status', 'active')
                                    ->whereNotNull('subscription_end_date')
                                    ->where('subscription_end_date', '<', Carbon::now())
                                    ->get();

        if ($expiredKoperasis->isEmpty()) {
            $this->info('No expired subscriptions found.');
            return;
        }

        // Find Free Tier (assuming price 0 or name contains Free)
        $freePackage = SubscriptionPackage::where('price', '<=', 0)
                                          ->where('is_active', true)
                                          ->orderBy('price', 'asc')
                                          ->first();

        foreach ($expiredKoperasis as $koperasi) {
            $this->info("Processing Koperasi: {$koperasi->nama} (ID: {$koperasi->id})");

            if ($freePackage) {
                // Downgrade to Free
                $koperasi->update([
                    'subscription_package_id' => $freePackage->id,
                    'status' => 'active', // Remain active but on free tier
                    'subscription_end_date' => Carbon::now()->addDays($freePackage->duration_days ?? 30),
                ]);
                $this->info("-> Downgraded to Free Package: {$freePackage->name}");
            } else {
                // No Free Tier -> Expire
                $koperasi->update([
                    'status' => 'expired',
                ]);
                $this->warn("-> No Free Package found. Status set to EXPIRED.");
            }
        }

        $this->info('Subscription check completed.');
    }
}
