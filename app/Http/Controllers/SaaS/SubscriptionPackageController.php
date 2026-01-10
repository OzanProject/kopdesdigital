<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;

class SubscriptionPackageController extends Controller
{
    public function index()
    {
        $packages = SubscriptionPackage::orderBy('price', 'asc')->get();
        return view('saas.subscription_packages.index', compact('packages'));
    }

    public function create()
    {
        return view('saas.subscription_packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_users' => 'required|integer|min:0', // 0 = Unlimited
            'max_members' => 'required|integer|min:0', // 0 = Unlimited
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        SubscriptionPackage::create([
            'name' => $request->name,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'max_users' => $request->max_users,
            'max_members' => $request->max_members,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('subscription-packages.index')->with('success', 'Paket langganan berhasil dibuat.');
    }

    public function show(SubscriptionPackage $subscriptionPackage)
    {
        return view('saas.subscription_packages.show', compact('subscriptionPackage'));
    }

    public function edit(SubscriptionPackage $subscriptionPackage)
    {
        return view('saas.subscription_packages.edit', compact('subscriptionPackage'));
    }

    public function update(Request $request, SubscriptionPackage $subscriptionPackage)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_users' => 'required|integer|min:0',
            'max_members' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $subscriptionPackage->update([
            'name' => $request->name,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'max_users' => $request->max_users,
            'max_members' => $request->max_members,
            'description' => $request->description,
            'is_active' => $request->has('is_active'), // Checkbox handling
        ]);

        return redirect()->route('subscription-packages.index')->with('success', 'Paket langganan berhasil diperbarui.');
    }

    public function destroy(SubscriptionPackage $subscriptionPackage)
    {
        // Optional: Check if used by any koperasi
        $subscriptionPackage->delete();
        return redirect()->route('subscription-packages.index')->with('success', 'Paket langganan berhasil dihapus.');
    }
}
