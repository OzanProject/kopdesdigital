<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        // Hanya tampilkan user milik koperasi login
        $users = User::where('koperasi_id', Auth::user()->koperasi_id)
                    ->with('roles')
                    ->oldest() // Menampilkan User pertama (Admin) di urutan pertama
                    ->paginate(10);
        
        return view('back.users.index', compact('users'));
    }

    public function create()
    {
        return view('back.users.create');
    }

    public function store(Request $request)
    {
        // Check Subscription Limits
        $koperasi = Auth::user()->koperasi;
        $package = $koperasi->subscriptionPackage;

        if ($package && $package->max_users > 0) {
            $currentUsers = User::where('koperasi_id', $koperasi->id)->count();
            if ($currentUsers >= $package->max_users) {
                return back()->with('error', "Batas jumlah user (admin/petugas) terlampaui. Paket {$package->name} hanya mengizinkan maksimal {$package->max_users} user. Silakan upgrade paket.");
            }
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin_koperasi,petugas'], // Batasi role yang bisa dibuat
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'koperasi_id' => Auth::user()->koperasi_id, // Auto-assign tenant
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        // Security Check: Tenant Isolation
        if ($user->koperasi_id != Auth::user()->koperasi_id) {
            abort(403);
        }

        return view('back.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
         if ($user->koperasi_id != Auth::user()->koperasi_id) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:admin_koperasi,petugas'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->koperasi_id != Auth::user()->koperasi_id) {
            abort(403);
        }
        
        if ($user->id == Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
