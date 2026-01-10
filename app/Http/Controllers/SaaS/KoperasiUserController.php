<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\Koperasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class KoperasiUserController extends Controller
{
    public function index(Koperasi $koperasi)
    {
        $users = $koperasi->users()->withoutGlobalScope('koperasi')
            ->select('users.*')
            ->leftJoin('model_has_roles', function($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                     ->where('model_has_roles.model_type', '=', 'App\Models\User');
            })
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->with(['roles'])
            // Priority: Admin Koperasi (1), Others (2)
            ->orderByRaw("
                CASE 
                    WHEN roles.name = 'admin_koperasi' THEN 1 
                    ELSE 2 
                END ASC
            ")
            ->orderBy('users.created_at', 'DESC')
            ->paginate(10);
        return view('saas.koperasi.users.index', compact('koperasi', 'users'));
    }

    public function create(Koperasi $koperasi)
    {
        return view('saas.koperasi.users.create', compact('koperasi'));
    }

    public function store(Request $request, Koperasi $koperasi)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'koperasi_id' => $koperasi->id,
        ]);

        // Default role for new tenant admin created by Super Admin
        $user->assignRole('admin_koperasi');

        return redirect()->route('koperasi.users.index', $koperasi->id)->with('success', 'Admin Koperasi berhasil ditambahkan.');
    }

    public function edit(Koperasi $koperasi, $userId)
    {
        $user = User::withoutGlobalScope('koperasi')->findOrFail($userId);
        return view('saas.koperasi.users.edit', compact('koperasi', 'user'));
    }

    public function update(Request $request, Koperasi $koperasi, $userId)
    {
        $user = User::withoutGlobalScope('koperasi')->findOrFail($userId);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
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

        return redirect()->route('koperasi.users.index', $koperasi->id)->with('success', 'Data admin berhasil diperbarui.');
    }

    public function destroy(Koperasi $koperasi, $userId)
    {
        $user = User::withoutGlobalScope('koperasi')->findOrFail($userId);
        
        if ($user->id == auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();
        return redirect()->route('koperasi.users.index', $koperasi->id)->with('success', 'User berhasil dihapus.');
    }
}
