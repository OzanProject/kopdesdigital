<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SubscriptionPackage::create([
            'name' => 'Free Tier',
            'price' => 0,
            'duration_days' => 3650, // 10 years
            'max_users' => 1,
            'max_members' => 50,
            'description' => 'Paket gratis untuk koperasi rintisan.',
        ]);

        \App\Models\SubscriptionPackage::create([
            'name' => 'Premium',
            'price' => 100000,
            'duration_days' => 30,
            'max_users' => 3,
            'max_members' => 500,
            'description' => 'Untuk koperasi berkembang dengan fitur lengkap.',
        ]);

        \App\Models\SubscriptionPackage::create([
            'name' => 'Enterprise',
            'price' => 250000,
            'duration_days' => 30,
            'max_users' => 10,
            'max_members' => 5000,
            'description' => 'Unlimited possibilities untuk koperasi besar.',
        ]);
    }
}
