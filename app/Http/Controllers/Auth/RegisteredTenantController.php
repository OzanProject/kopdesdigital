<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class RegisteredTenantController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request)
    {
        $selectedPackage = null;
        if ($request->has('package')) {
            $selectedPackage = \App\Models\SubscriptionPackage::where('is_active', true)->find($request->package);
        }
        $packages = \App\Models\SubscriptionPackage::where('is_active', true)->get();
        
        return view('auth.register_tenant', compact('selectedPackage', 'packages'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            // User Data
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
            // Koperasi Data
            'koperasi_name' => ['required', 'string', 'max:255', 'unique:koperasis,nama'],
            'koperasi_address' => ['required', 'string'],
            'koperasi_phone' => ['nullable', 'string', 'max:20'],
            'package_id' => [
                'required', 
                \Illuminate\Validation\Rule::exists('subscription_packages', 'id')->where(function ($query) {
                    return $query->where('is_active', true);
                }),
            ],
        ], [
            'email.unique' => 'Email ini sudah digunakan. Silakan login atau gunakan email lain.',
            'koperasi_name.unique' => 'Nama Koperasi ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal :min karakter.',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Create Koperasi (Pending Payment)
                $package = \App\Models\SubscriptionPackage::find($request->package_id);
                
                $koperasi = \App\Models\Koperasi::create([
                    'nama' => $request->koperasi_name,
                    'alamat' => $request->koperasi_address,
                    'telepon' => $request->koperasi_phone,
                    'status' => 'pending_payment', // Changed from active
                    'subscription_package_id' => $package->id,
                    'subscription_end_date' => null, // Will be set after payment
                ]);

                // 2. Create User (Admin Koperasi)
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'koperasi_id' => $koperasi->id,
                ]);

                $user->assignRole('admin_koperasi');

                // 3. Create Transaction
                $orderId = 'INV-' . time() . '-' . $koperasi->id;
                $isFree = $package->price <= 0;

                $transaction = \App\Models\SubscriptionTransaction::create([
                    'koperasi_id' => $koperasi->id,
                    'subscription_package_id' => $package->id,
                    'order_id' => $orderId,
                    'amount' => $package->price,
                    'status' => $isFree ? 'paid' : 'pending',
                ]);

                if ($isFree) {
                    // Activate instantly
                    $koperasi->update([
                        'status' => 'active',
                        'subscription_end_date' => now()->addDays(30)
                    ]);
                    
                    session(['registration_success' => true]); // Flag for dashboard welcome message if needed
                } else {
                    // 4. Generate Snap Token
                    $midtrans = new \App\Services\MidtransService();
                    $snapToken = $midtrans->getSnapToken($transaction);
                    $transaction->update(['snap_token' => $snapToken]);
                    
                    // Store order_id in session to redirect to payment
                    session(['pending_order_id' => $orderId]);
                }

                // 5. Login User
                Auth::login($user);
                
                // 6. Send Notification
                try {
                    $user->notify(new \App\Notifications\WelcomeTenantNotification($koperasi, $transaction));
                } catch (\Exception $e) {
                    \Log::error('Email Error: ' . $e->getMessage());
                }
            });

            // Redirect based on payment status
            if (session('pending_order_id')) {
                return redirect()->route('payment.show', ['order_id' => session('pending_order_id')]);
            } else {
                return redirect()->route('dashboard');
            }

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat pendaftaran: ' . $e->getMessage()]);
        }
    }
}
