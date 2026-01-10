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
}
