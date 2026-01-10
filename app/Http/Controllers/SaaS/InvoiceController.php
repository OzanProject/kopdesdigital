<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionTransaction;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = SubscriptionTransaction::with(['koperasi', 'package'])
            ->latest()
            ->get();

        return view('saas.invoices.index', compact('invoices'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoice = SubscriptionTransaction::with(['koperasi', 'package'])->findOrFail($id);
        
        return view('saas.invoices.show', compact('invoice'));
    }

    public function approve($id)
    {
        $transaction = SubscriptionTransaction::findOrFail($id);
        
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi tidak dalam status pending.');
        }

        $transaction->update([
            'status' => 'paid',
            'payment_type' => 'manual_admin_approval',
            'payment_details' => ['approved_at' => now(), 'by' => auth()->user()->id]
        ]);

        // Activate Koperasi
        $koperasi = $transaction->koperasi;
        
        // Calculate end date (Extend if already active, or set from now)
        $currentEnd = $koperasi->subscription_end_date ? \Carbon\Carbon::parse($koperasi->subscription_end_date) : now();
        if ($currentEnd->isPast()) {
            $currentEnd = now();
        }
        
        $duration = 30; // Default 30 days, or get from package
        if ($transaction->package) {
            $duration = $transaction->package->duration_in_days ?? 30;
        }

        $koperasi->update([
            'status' => 'active',
            'subscription_end_date' => $currentEnd->addDays($duration)
        ]);

        return back()->with('success', 'Pembayaran manual telah disetujui. Akun koperasi aktif.');
    }
}
