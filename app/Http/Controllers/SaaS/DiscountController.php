<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::latest()->paginate(10);
        return view('saas.discounts.index', compact('discounts'));
    }

    public function create()
    {
        return view('saas.discounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:discounts,code|max:50',
            'type' => 'required|in:fixed,percent',
            'amount' => 'required|numeric|min:0',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'max_uses' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        Discount::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'amount' => $request->amount,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'max_uses' => $request->max_uses,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('discounts.index')->with('success', 'Kode promo berhasil dibuat.');
    }

    public function edit(Discount $discount)
    {
        return view('saas.discounts.edit', compact('discount'));
    }

    public function update(Request $request, Discount $discount)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:discounts,code,' . $discount->id,
            'type' => 'required|in:fixed,percent',
            'amount' => 'required|numeric|min:0',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'max_uses' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        $discount->update([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'amount' => $request->amount,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'max_uses' => $request->max_uses,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('discounts.index')->with('success', 'Kode promo berhasil diperbarui.');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('discounts.index')->with('success', 'Kode promo berhasil dihapus.');
    }
}
