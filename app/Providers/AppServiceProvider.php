<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        // Force Queue to Sync (Immediate Delivery) for Shared Hosting
        // This overrides .env QUEUE_CONNECTION=database which causes emails to not send if no worker is running
        config(['queue.default' => 'sync']);

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('saas_settings')) {
                $settings = \App\Models\SaasSetting::all()->pluck('value', 'key');
                
                if (isset($settings['mail_host'])) {
                    config([
                        'mail.mailers.smtp.host' => $settings['mail_host'],
                        'mail.mailers.smtp.port' => $settings['mail_port'] ?? 587,
                        'mail.mailers.smtp.encryption' => $settings['mail_encryption'] ?? 'tls',
                        'mail.mailers.smtp.username' => $settings['mail_username'],
                        'mail.mailers.smtp.password' => $settings['mail_password'],
                        'mail.from.address' => $settings['mail_from_address'] ?? 'noreply@koperasi.com',
                        'mail.from.name' => $settings['mail_from_name'] ?? 'KopDes Digital',
                    ]);
                }
                
                // Share settings with all views
                \Illuminate\Support\Facades\View::share('settings', $settings);
            }
        } catch (\Exception $e) {
            // Ignore during migration or if DB not ready
        }
    }
}
