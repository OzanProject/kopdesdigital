<?php

namespace App\Imports;

use App\Models\Nasabah;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class NasabahImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    private $koperasiId;
    private $maxMembers;
    private $currentCount;

    public function __construct()
    {
        $this->koperasiId = Auth::user()->koperasi_id;
        $koperasi = Auth::user()->koperasi;
        $package = $koperasi->subscriptionPackage;
        $this->maxMembers = $package ? $package->max_members : 0;
        $this->currentCount = Nasabah::where('koperasi_id', $this->koperasiId)->count();
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Check Limit
        if ($this->maxMembers > 0 && $this->currentCount >= $this->maxMembers) {
            throw new \Exception("Impor dihentikan. Batas jumlah nasabah terlampaui ({$this->maxMembers}). Silakan upgrade paket.");
        }
        // Skip if NIK already exists in this Koperasi
        $exists = Nasabah::where('koperasi_id', $this->koperasiId)
                         ->where('nik', $row['nik'])
                         ->exists();
        
        if ($exists) {
            return null;
        }

        $nasabah = Nasabah::create([
            'koperasi_id'     => $this->koperasiId,
            'nama'            => $row['nama'],
            'nik'             => $row['nik'],
            'no_anggota'      => Nasabah::generateNoAnggota($this->koperasiId),
            'alamat'          => $row['alamat'] ?? null,
            'telepon'         => $row['telepon'] ?? null,
            'pekerjaan'       => $row['pekerjaan'] ?? null,
            'status'          => 'active',
            'tanggal_bergabung' => now(),
        ]);

        $this->currentCount++; // Increment count

        // Create User Login if provided
        if (!empty($row['email']) && !empty($row['password'])) {
            // Check if email unique
            if (!\App\Models\User::where('email', $row['email'])->exists()) {
                $user = \App\Models\User::create([
                    'name'        => $row['nama'],
                    'email'       => $row['email'],
                    'password'    => \Illuminate\Support\Facades\Hash::make($row['password']),
                    'koperasi_id' => $this->koperasiId,
                ]);

                $user->assignRole('member');
                $nasabah->update(['user_id' => $user->id]);
            }
        }

        return $nasabah;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required',
            'nik'  => 'required|numeric',
        ];
    }
}
