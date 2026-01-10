<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin (Ardiansyah)
        $superAdmin = User::firstOrCreate(
            ['email' => 'ardiansyahdzan@gmail.com'],
            [
                'name' => 'Ardiansyah (Super Admin)',
                'password' => Hash::make('password'),
                'koperasi_id' => null, // Global user
            ]
        );
        $superAdmin->assignRole('super_admin');

        // Initial Koperasi for testing
        $koperasi = \App\Models\Koperasi::firstOrCreate(
            ['nama' => 'Koperasi Maju Jaya'],
            [
                'alamat' => 'Jl. Merdeka No. 1',
                'status' => 'active',
            ]
        );

        // Admin Koperasi
        $admin = User::firstOrCreate(
            ['email' => 'admin@majujaya.com'],
            [
                'name' => 'Admin Koperasi',
                'password' => Hash::make('password'),
                'koperasi_id' => $koperasi->id,
            ]
        );
        $admin->assignRole('admin_koperasi');
    }
}
