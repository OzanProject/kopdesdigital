<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'koperasi_name' => ['required', 'string', 'max:255', 'unique:koperasis,name'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Create Koperasi
        $packageId = $request->package_id;
        // If package_id is invalid or null, user creates without package or default free? 
        // For now, allow null or set default if needed. 
        // Best to check if package exists.
        if ($packageId && !\App\Models\SubscriptionPackage::find($packageId)) {
            $packageId = null;
        }

        $koperasi = \App\Models\Koperasi::create([
            'name' => $request->koperasi_name,
            'slug' => \Illuminate\Support\Str::slug($request->koperasi_name),
            'subscription_package_id' => $packageId,
            'status' => $packageId ? 'active' : 'pending_payment', // Logic can vary
            'email' => $request->email, // Default to admin email
        ]);

        // Link User to Koperasi
        $user->koperasi_id = $koperasi->id;
        $user->save();

        // Assign Role
        $user->assignRole('admin_koperasi');

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
