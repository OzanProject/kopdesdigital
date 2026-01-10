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

        // 1. Force APP_URL to match the current Domain (Fixes broken images in Email)
        // If not running in console (i.e. web request), use the actual Host
        if (!app()->runningInConsole() && isset($_SERVER['HTTP_HOST'])) {
             $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
             $currentUrl = $protocol . $_SERVER['HTTP_HOST'];
             config([
                 'app.url' => $currentUrl,
                 'app.asset_url' => $currentUrl, // Force asset() to use domain
             ]);
        }

        // Force Queue to Sync (Immediate Delivery) for Shared Hosting
        // This overrides .env QUEUE_CONNECTION=database which causes emails to not send if no worker is running
        config(['queue.default' => 'sync']);

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('saas_settings')) {
                $settings = \App\Models\SaasSetting::all()->pluck('value', 'key');
                
                if (isset($settings['mail_host'])) {
                    // Set App Name dynamically from DB for Email Templates
                    if (isset($settings['app_name'])) {
                        config(['app.name' => $settings['app_name']]);
                    }

                    config([
                        'mail.default' => 'smtp', // FORCE USE SMTP instead of log/local
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
