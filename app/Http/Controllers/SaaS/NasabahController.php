<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NasabahController extends Controller
{
    public function index(Request $request)
    {
        $query = Nasabah::with('user')->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_anggota', 'like', "%{$search}%");
            });
        }

        $nasabahs = $query->paginate(10);
        return view('back.nasabah.index', compact('nasabahs'));
    }

    public function create()
    {
        return view('back.nasabah.create');
    }

    public function store(Request $request)
    {
        // Koperasi ID handled by Global Scope/Constraint but better explicit for unique check
        $koperasiId = Auth::user()->koperasi_id;

        // Check Subscription Limits
        $koperasi = Auth::user()->koperasi;
        $package = $koperasi->subscriptionPackage;

        if ($package && $package->max_members > 0) {
            $currentMembers = Nasabah::where('koperasi_id', $koperasiId)->count();
            if ($currentMembers >= $package->max_members) {
                return back()->with('error', "Batas jumlah nasabah terlampaui. Paket {$package->name} hanya mengizinkan maksimal {$package->max_members} nasabah. Silakan upgrade paket.");
            }
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => "required|numeric|unique:nasabahs,nik,NULL,id,koperasi_id,{$koperasiId}", 
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:100',
            // Login Validation
            'create_login' => 'nullable|boolean',
            'email' => 'nullable|required_if:create_login,1|email|unique:users,email',
            'password' => 'nullable|required_if:create_login,1|min:8',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $koperasiId) {
            // 1. Create Nasabah
            $nasabahData = \Illuminate\Support\Arr::except($validated, ['create_login', 'email', 'password']);
            $nasabahData['koperasi_id'] = $koperasiId;
            $nasabahData['no_anggota'] = Nasabah::generateNoAnggota($koperasiId);
            $nasabahData['tanggal_bergabung'] = now();
            $nasabahData['status'] = 'active';

            $nasabah = Nasabah::create($nasabahData);

            // 2. Create User if requested
            if (!empty($validated['create_login'])) {
                $user = \App\Models\User::create([
                    'name' => $nasabah->nama,
                    'email' => $validated['email'],
                    'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
                    'koperasi_id' => $koperasiId,
                ]);

                $user->assignRole('member');
                
                // Link User to Nasabah
                $nasabah->update(['user_id' => $user->id]);
            }
        });

        return redirect()->route('nasabah.index')->with('success', 'Nasabah berhasil ditambahkan.');
    }

    public function edit(Nasabah $nasabah)
    {
        return view('back.nasabah.edit', compact('nasabah'));
    }

    public function update(Request $request, Nasabah $nasabah)
    {
        $koperasiId = Auth::user()->koperasi_id;

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => "required|numeric|unique:nasabahs,nik,{$nasabah->id},id,koperasi_id,{$koperasiId}",
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'pekerjaan' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,keluar',
            // Login Validation
            'create_login' => 'nullable|boolean',
            'email' => ['nullable', 'email', \Illuminate\Validation\Rule::unique('users')->ignore($nasabah->user_id)],
            // Password only required if creating new login, or nullable if updating
            'password' => 'nullable|min:8', 
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $nasabah, $koperasiId) {
            // 1. Update Nasabah
            $nasabahData = \Illuminate\Support\Arr::except($validated, ['create_login', 'email', 'password']);
            $nasabah->update($nasabahData);

            // 2. Handle User Account
            // Case A: User exists -> Update Email/Password
            if ($nasabah->user) {
                $userData = ['email' => $validated['email']];
                if (!empty($validated['password'])) {
                    $userData['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
                }
                $nasabah->user->update($userData);
            } 
            // Case B: User doesn't exist AND 'create_login' is checked -> Create User
            elseif (!empty($validated['create_login']) && !empty($validated['email']) && !empty($validated['password'])) {
                 $user = \App\Models\User::create([
                    'name' => $nasabah->nama,
                    'email' => $validated['email'],
                    'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
                    'koperasi_id' => $koperasiId,
                ]);

                $user->assignRole('member');
                $nasabah->update(['user_id' => $user->id]);
            }
        });

        return redirect()->route('nasabah.index')->with('success', 'Data nasabah diperbarui.');
    }

    public function destroy(Nasabah $nasabah)
    {
        $nasabah->delete();
        return redirect()->route('nasabah.index')->with('success', 'Nasabah dihapus.');
    }

    public function import(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\NasabahImport, $request->file('file'));
            return redirect()->route('nasabah.index')->with('success', 'Data nasabah berhasil diimpor.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal impor data: ' . $e->getMessage());
        }
    }

    public function template()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\NasabahTemplateExport, 'template_nasabah.xlsx');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:nasabahs,id',
        ]);

        $koperasiId = Auth::user()->koperasi_id;
        
        // Ensure all IDs belong to the current koperasi to prevent unauthorized deletion
        $count = Nasabah::where('koperasi_id', $koperasiId)
                        ->whereIn('id', $request->ids)
                        ->delete();

        return redirect()->route('nasabah.index')->with('success', $count . ' Nasabah berhasil dihapus.');
    }
    public function bulkPrint(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:nasabahs,id',
        ]);

        $nasabahs = Nasabah::where('koperasi_id', Auth::user()->koperasi_id)
                           ->whereIn('id', $request->ids)
                           ->get();

        return view('back.nasabah.print_card', compact('nasabahs'));
    }
}
