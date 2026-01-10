<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $superAdmin = Role::create(['name' => 'super_admin']);
        $adminKoperasi = Role::create(['name' => 'admin_koperasi']);
        $petugas = Role::create(['name' => 'petugas']);
        $member = Role::create(['name' => 'member']);

        // Define Permissions (can be expanded later)
        $permissions = [
            'manage_koperasi', // Super Admin only
            'manage_users',
            'manage_nasabah',
            'manage_simpanan',
            'manage_pinjaman',
            'view_reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign Permissions
        $superAdmin->givePermissionTo(Permission::all());
        
        $adminKoperasi->givePermissionTo([
            'manage_users',
            'manage_nasabah',
            'manage_simpanan',
            'manage_pinjaman',
            'view_reports',
        ]);
        
        $petugas->givePermissionTo([
            'manage_nasabah',
            'manage_simpanan',
            'manage_pinjaman',
        ]);
    }
}
