<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionTransaction;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show($order_id)
    {
        $transaction = SubscriptionTransaction::where('order_id', $order_id)->firstOrFail();
        
        // Ensure user is authorized to view this transaction
        if (auth()->check() && $transaction->koperasi_id !== auth()->user()->koperasi_id) {
           abort(403);
        }

        // Regenerate token if missing
        if (!$transaction->snap_token && $transaction->status == 'pending') {
            $midtrans = new MidtransService();
            $token = $midtrans->getSnapToken($transaction);
            $transaction->update(['snap_token' => $token]);
        }

        $settings = \App\Models\SaasSetting::all()->pluck('value', 'key');

        return view('payment.checkout', compact('transaction', 'settings'));
    }

    public function callback(Request $request)
    {
        // Fix: Retrieve correct key based on Production/Sandbox toggle
        $settings = \App\Models\SaasSetting::pluck('value', 'key');
        $isProduction = isset($settings['midtrans_is_production']) && $settings['midtrans_is_production'] === '1';
        
        if ($isProduction) {
            $serverKey = $settings['midtrans_server_key_production'] ?? '';
        } else {
            $serverKey = $settings['midtrans_server_key_sandbox'] ?? config('services.midtrans.server_key');
        }
        
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        
        if ($hashed == $request->signature_key) {
            $transaction = SubscriptionTransaction::where('order_id', $request->order_id)->first();
            
            if (!$transaction) return response()->json(['message' => 'Transaction not found'], 404);

            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $transaction->update([
                    'status' => 'paid',
                    'payment_type' => $request->payment_type,
                    'payment_details' => $request->all()
                ]);

                // Activate Koperasi
                $koperasi = $transaction->koperasi;
                $koperasi->update([
                    'status' => 'active',
                    // Extend 30 days from now, or from existing end date? Assuming new purchase:
                    'subscription_end_date' => now()->addDays(30)
                ]);
            } elseif ($request->transaction_status == 'expire' || $request->transaction_status == 'cancel' || $request->transaction_status == 'deny') {
                $transaction->update(['status' => 'failed']);
            }
            return response()->json(['message' => 'Success']);
        }
        
        return response()->json(['message' => 'Invalid Signature'], 400);
    }
    
    public function success()
    {
        return view('payment.success');
    }

    public function renew($order_id)
    {
        $transaction = SubscriptionTransaction::where('order_id', $order_id)->firstOrFail();

        // Ensure ownership
        if (auth()->check() && $transaction->koperasi_id !== auth()->user()->koperasi_id) {
            abort(403);
        }

        // Generate new Order ID to avoid Midtrans duplication error
        $newOrderId = 'INV-' . time() . '-' . $transaction->koperasi_id;
        
        $transaction->update([
            'order_id' => $newOrderId,
            'snap_token' => null // Trigger regeneration in show()
        ]);

        return redirect()->route('payment.show', $newOrderId);
    }
}
