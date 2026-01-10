<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Setup Brand Identity
        \App\Models\SaasSetting::updateOrCreate(
            ['key' => 'app_name'],
            ['value' => 'KopDes Digital']
        );
        \App\Models\SaasSetting::updateOrCreate(
            ['key' => 'hero_title'],
            ['value' => 'Revolusi Koperasi Desa Digital']
        );
        \App\Models\SaasSetting::updateOrCreate(
            ['key' => 'hero_subtitle'],
            ['value' => 'Kelola simpanan, pinjaman, dan anggota koperasi Anda dengan mudah, transparan, dan aman menggunakan teknologi terkini.']
        );

        // 2. Seed Features
        \App\Models\LandingFeature::truncate();
        $features = [
            [
                'title' => 'Manajemen Anggota',
                'description' => 'Data anggota terpusat, mudah dicari, dan dikelola dengan riwayat transaksi yang lengkap.',
                'icon' => 'fas fa-users',
                'order' => 1
            ],
            [
                'title' => 'Laporan Keuangan Otomatis',
                'description' => 'Generasi laporan neraca, laba rugi, dan arus kas secara realtime tanpa ribet.',
                'icon' => 'fas fa-chart-line',
                'order' => 2
            ],
            [
                'title' => 'Aman & Terpercaya',
                'description' => 'Sistem keamanan enkripsi tingkat tinggi untuk melindungi data sensitif koperasi Anda.',
                'icon' => 'fas fa-shield-alt',
                'order' => 3
            ],
            [
                'title' => 'Akses Multi-Platform',
                'description' => 'Bisa diakses dari Laptop, Tablet, maupun Smartphone kapan saja dan di mana saja.',
                'icon' => 'fas fa-mobile-alt',
                'order' => 4
            ]
        ];
        foreach ($features as $f) {
            \App\Models\LandingFeature::create($f);
        }

        // 3. Seed FAQs
        \App\Models\LandingFaq::truncate();
        $faqs = [
            [
                'question' => 'Apa itu KopDes Digital?',
                'answer' => 'KopDes Digital adalah platform SaaS (Software as a Service) yang membantu pengurus koperasi desa mengelola administrasi dan keuangan secara digital.',
                'order' => 1
            ],
            [
                'question' => 'Apakah data saya aman?',
                'answer' => 'Tentu saja. Kami menggunakan enkripsi SSL standard perbankan dan backup data rutin setiap hari.',
                'order' => 2
            ],
            [
                'question' => 'Berapa biaya berlangganan?',
                'answer' => 'Kami menawarkan berbagai paket mulai dari Gratis (Free Tier) hingga Enterprise. Cek tabel harga di halaman utama.',
                'order' => 3
            ]
        ];
        foreach ($faqs as $fq) {
            \App\Models\LandingFaq::create($fq);
        }

        // 4. Seed Testimonials
        \App\Models\LandingTestimonial::truncate();
        $testimonials = [
            [
                'name' => 'H. Suhendar',
                'role' => 'Ketua Koperasi Tani Makmur',
                'content' => 'Sejak pakai KopDes Digital, pembukuan jadi rapi banget. Rapat anggota tahunan jadi lebih tenang karena data transparan.',
                'rating' => 5,
                'avatar' => null
            ],
            [
                'name' => 'Siti Aminah',
                'role' => 'Bendahara Koperasi PKK',
                'content' => 'Fitur simpan pinjamnya sangat membantu. Hitung bunga dan cicilan otomatis, jadi nggak perlu kalkulator lagi!',
                'rating' => 5,
                'avatar' => null
            ]
        ];
        foreach ($testimonials as $t) {
            \App\Models\LandingTestimonial::create($t);
        }
    }
}
