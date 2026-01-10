<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LandingFeature;
use App\Models\LandingFaq;
use App\Models\LandingTestimonial;

class LandingContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Premium Features
        LandingFeature::truncate();
        
        $features = [
            [
                'icon' => 'fas fa-cloud',
                'title' => 'Teknologi Cloud Terintegrasi',
                'description' => 'Akses data koperasi Anda dari mana saja dan kapan saja dengan keamanan tingkat enterprise. Server kami menjamin uptime 99.9%.',
                'order' => 1,
            ],
            [
                'icon' => 'fas fa-shield-alt',
                'title' => 'Sistem Keamanan Berlapis',
                'description' => 'Data anggota dan keuangan dilindungi dengan enkripsi mutakhir. Kami memprioritaskan privasi dan keamanan aset digital Anda.',
                'order' => 2,
            ],
            [
                'icon' => 'fas fa-chart-line',
                'title' => 'Analitik Keuangan Real-Time',
                'description' => 'Pantau kesehatan finansial koperasi melalui dashboard pintar. Dapatkan wawasan mendalam untuk pengambilan keputusan strategis.',
                'order' => 3,
            ],
            [
                'icon' => 'fas fa-mobile-alt',
                'title' => 'Mobile Friendly Experience',
                'description' => 'Aplikasi dirancang responsif untuk semua perangkat. Anggota dapat mengecek saldo dan mengajukan pinjaman hanya melalui smartphone.',
                'order' => 4,
            ],
        ];

        foreach ($features as $feature) {
            LandingFeature::create($feature);
        }

        // 2. Professional FAQs
        LandingFaq::truncate();

        $faqs = [
            [
                'question' => 'Apakah data koperasi kami aman?',
                'answer' => 'Sangat aman. Kami menggunakan enkripsi SSL 256-bit dan infrastruktur cloud yang setara dengan standar perbankan digital. Backup data dilakukan secara otomatis setiap hari untuk mencegah kehilangan data.',
                'order' => 1,
            ],
            [
                'question' => 'Bagaimana jika saya ingin berhenti berlangganan?',
                'answer' => 'Kami menawarkan fleksibilitas penuh. Anda dapat berhenti berlangganan kapan saja tanpa biaya penalti. Anda juga dapat mengekspor seluruh data koperasi Anda sebelum menutup akun.',
                'order' => 2,
            ],
            [
                'question' => 'Apakah tersedia pelatihan untuk pengurus?',
                'answer' => 'Tentu. Setiap paket berlangganan mencakup sesi onboarding eksklusif dan akses ke perpustakaan panduan video kami. Tim support prioritas kami juga siap membantu Anda 24/7.',
                'order' => 3,
            ],
            [
                'question' => 'Berapa lama proses aktivasi akun?',
                'answer' => 'Instan. Setelah Anda memilih paket dan melakukan pembayaran, sistem kami secara otomatis membangun instansi cloud khusus untuk koperasi Anda dalam hitungan detik. Anda bisa langsung bekerja.',
                'order' => 4,
            ],
        ];

        foreach ($faqs as $faq) {
            LandingFaq::create($faq);
        }

        // 3. Luxury Testimonials
        LandingTestimonial::truncate();

        $testimonials = [
            [
                'name' => 'Budi Santoso, M.M.',
                'role' => 'Ketua Koperasi makmur Sejahtera',
                'content' => 'Transformasi digital yang luar biasa. Sejak menggunakan platform ini, transparansi meningkat drastis dan kepercayaan anggota bertambah. Fitur laporannya sangat memanjakan mata dan mudah dipahami.',
                'rating' => 5,
                'avatar' => null, // Will use UI Avatars
            ],
            [
                'name' => 'Siti Aminah',
                'role' => 'Bendahara Koperasi Unit Desa',
                'content' => 'Dulu saya lembur tiap akhir bulan untuk rekap buku besar. Sekarang, Laporan SHU dan Neraca selesai dalam satu klik. Benar-benar solusi yang efisien dan elegan. Sangat direkomendasikan!',
                'rating' => 5,
                'avatar' => null,
            ],
            [
                'name' => 'Ir. Hendra Wijaya',
                'role' => 'Ketua Pengawas Koperasi Karyawan',
                'content' => 'Tampilan dashboard-nya sangat profesional dan modern. Memberikan kesan bonafide pada koperasi kami. Sistem notifikasinya juga sangat membantu mengingatkan anggota tanggal jatuh tempo.',
                'rating' => 5,
                'avatar' => null,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            LandingTestimonial::create($testimonial);
        }
    }
}
