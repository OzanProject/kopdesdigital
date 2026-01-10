<?php

namespace App\Services;

use App\Models\SaasSetting;
use App\Models\SubscriptionTransaction;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        $this->configure();
    }

    public function configure()
    {
        // Get Settings
        $settings = SaasSetting::all()->pluck('value', 'key');
        
        $isProduction = isset($settings['midtrans_is_production']) && $settings['midtrans_is_production'] === '1';

        Config::$isProduction = $isProduction;
        
        if ($isProduction) {
            Config::$serverKey = $settings['midtrans_server_key_production'] ?? '';
        } else {
            Config::$serverKey = $settings['midtrans_server_key_sandbox'] ?? config('services.midtrans.server_key');
        }

        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function getSnapToken(SubscriptionTransaction $transaction)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->order_id,
                'gross_amount' => (int) $transaction->amount,
            ],
            'customer_details' => [
                'first_name' => $transaction->koperasi->nama,
                'email' => $transaction->koperasi->user->email ?? 'noreply@example.com',
                'phone' => $transaction->koperasi->telepon,
            ],
            'item_details' => [
                [
                    'id' => $transaction->package->id,
                    'price' => (int) $transaction->amount,
                    'quantity' => 1,
                    'name' => 'Paket ' . $transaction->package->name . ' (1 Bulan)',
                ]
            ],
            'callbacks' => [
                'finish' => route('dashboard'),
            ],
            // Override Notification URL (Otomatis tanpa setting dashboard)
            'notification_url' => [route('midtrans.callback')],
        ];

        try {
            return Snap::getSnapToken($params);
        } catch (\Exception $e) {
            \Log::error('Midtrans Snap Error: ' . $e->getMessage());
            return null;
        }
    }
}
