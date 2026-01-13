<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubscriptionPackage;
use App\Models\SubscriptionTransaction;
use App\Services\MidtransService;

class SubscriptionController extends Controller
{
    public function index()
    {
        $koperasi = Auth::user()->koperasi;
        $currentPackage = $koperasi->subscriptionPackage;
        $packages = SubscriptionPackage::where('is_active', true)->get();
        
        // Get active discounts
        $availableDiscounts = \App\Models\Discount::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('valid_until')->orWhere('valid_until', '>=', now());
            })
            ->where(function($q) {
                $q->whereNull('max_uses')->orWhereColumn('used_count', '<', 'max_uses');
            })
            ->latest()
            ->get();

        // Get recent transactions
        $transactions = SubscriptionTransaction::where('koperasi_id', $koperasi->id)
                        ->latest()
                        ->take(5)
                        ->get();

        return view('back.subscription.index', compact('koperasi', 'currentPackage', 'packages', 'transactions', 'availableDiscounts'));
    }

    public function upgrade(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:subscription_packages,id',
            'discount_code' => 'nullable|string|exists:discounts,code'
        ]);

        $koperasi = Auth::user()->koperasi;
        $package = SubscriptionPackage::find($request->package_id);
        
        $discountAmount = 0;
        $discountId = null;
        $discountCode = null;

        // Apply Discount
        if ($request->filled('discount_code')) {
            $discount = \App\Models\Discount::where('code', strtoupper($request->discount_code))->first();
            if ($discount && $discount->isValid()) {
                $discountCode = $discount->code;
                $discountId = $discount->id;
                
                if ($discount->type == 'fixed') {
                    $discountAmount = $discount->amount;
                } else {
                    $discountAmount = ($package->price * $discount->amount) / 100;
                }

                // Ensure discount doesn't exceed price
                if ($discountAmount > $package->price) {
                    $discountAmount = $package->price;
                }
                
                // Increment Usage
                $discount->increment('used_count');
            }
        }

        $finalAmount = $package->price - $discountAmount;
        $orderId = 'INV-' . time() . '-' . $koperasi->id;

        $transaction = SubscriptionTransaction::create([
            'koperasi_id' => $koperasi->id,
            'subscription_package_id' => $package->id,
            'order_id' => $orderId,
            'amount' => $finalAmount,
            'status' => 'pending',
            'notes' => 'Upgrade/Renew Subscription',
            'discount_id' => $discountId,
            'discount_code' => $discountCode,
            'discount_amount' => $discountAmount
        ]);

        if ($finalAmount <= 0) {
            $transaction->update(['status' => 'paid']);
            $koperasi->update([
                'subscription_package_id' => $package->id,
                'status' => 'active'
            ]);
            return redirect()->route('subscription.index')->with('success', 'Paket berhasil diperbarui ke ' . $package->name . ' (Diskon 100%)');
        }

        // Generate Midtrans Token
        try {
            $midtrans = new MidtransService();
            $token = $midtrans->getSnapToken($transaction);
            $transaction->update(['snap_token' => $token]);
            
            return redirect()->route('payment.show', $transaction->order_id);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function checkCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'package_id' => 'required|exists:subscription_packages,id'
        ]);

        $package = SubscriptionPackage::find($request->package_id);
        $amount = $package->price;

        $discount = \App\Models\Discount::where('code', strtoupper($request->code))->first();

        if (!$discount || !$discount->isValid()) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode promo tidak valid atau sudah habis.'
            ]);
        }

        $discountValue = 0;
        if ($discount->type == 'fixed') {
            $discountValue = $discount->amount;
        } else {
            $discountValue = ($amount * $discount->amount) / 100;
        }

        if ($discountValue > $amount) {
            $discountValue = $amount;
        }
        
        return response()->json([
            'valid' => true,
            'code' => $discount->code,
            'discount_amount' => $discountValue,
            'final_amount' => $amount - $discountValue,
            'message' => 'Kode promo berhasil digunakan! Hemat Rp ' . number_format($discountValue, 0, ',', '.')
        ]);
    }


    public function destroyTransaction($id)
    {
        $koperasi = Auth::user()->koperasi;
        $transaction = SubscriptionTransaction::where('koperasi_id', $koperasi->id)
                                              ->where('id', $id)
                                              ->firstOrFail();

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Hanya transaksi dengan status Pending yang dapat dihapus.');
        }

        $transaction->delete();

        return back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
