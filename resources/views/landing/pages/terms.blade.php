@extends('layouts.landing')

@section('title', 'Syarat & Ketentuan')

@section('content')
<style>
    /* Konsistensi Desain dengan Legal Page sebelumnya */
    .legal-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 120px 0 60px;
        border-bottom: 1px solid #e2e8f0;
    }
    .legal-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.02);
        padding: 50px;
        margin-top: -40px;
        position: relative;
        z-index: 10;
    }
    .content-body h3 {
        color: #0f172a;
        font-weight: 700;
        font-size: 1.25rem;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
    }
    .content-body p, .content-body li {
        color: #475569;
        line-height: 1.8;
        font-size: 1.05rem;
    }
    .content-body ul {
        padding-left: 1.2rem;
        margin-bottom: 1.5rem;
    }
    .last-updated {
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        padding: 6px 16px;
        border-radius: 100px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }
    .terms-highlight {
        border-left: 4px solid #0d6efd;
        padding-left: 20px;
        font-style: italic;
        background: #f8fafc;
        padding: 20px;
        border-radius: 0 12px 12px 0;
        margin: 20px 0;
    }
</style>

<div class="legal-header">
    <div class="container text-center">
        <div class="last-updated mb-3">Terakhir diperbarui: {{ date('d F Y') }}</div>
        <h1 class="fw-extrabold display-4 text-dark mb-0">Syarat & Ketentuan</h1>
    </div>
</div>

<div class="container pb-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="legal-card shadow-sm">
                <div class="content-body">
                    @if(!empty($settings['terms_content']))
                        {!! $settings['terms_content'] !!}
                    @else
                        {{-- Professional Default Content --}}
                        <div class="terms-highlight">
                            Mohon baca syarat dan ketentuan ini dengan saksama sebelum menggunakan layanan kami. Dengan menggunakan platform ini, Anda dianggap telah menyetujui seluruh butir perjanjian ini.
                        </div>

                        <h3>1. Syarat Penggunaan</h3>
                        <p>Dengan mengakses website <strong>{{ $settings['app_name'] ?? 'KopDes Digital' }}</strong>, Anda setuju untuk terikat dengan syarat layanan ini, semua hukum dan peraturan yang berlaku, dan setuju bahwa Anda bertanggung jawab untuk mematuhi hukum lokal yang berlaku di wilayah hukum Republik Indonesia.</p>

                        <h3>2. Lisensi Penggunaan (SaaS)</h3>
                        <p>Layanan kami diberikan berbasis langganan perangkat lunak (Software as a Service). Lisensi ini bersifat terbatas, tidak eksklusif, dan tidak dapat dipindahtangankan. Anda dilarang keras untuk:</p>
                        <ul>
                            <li>Menyalin, memodifikasi, atau merekayasa balik (reverse engineering) kode sumber aplikasi.</li>
                            <li>Menggunakan layanan untuk tujuan ilegal atau melanggar hak kekayaan intelektual.</li>
                            <li>Menjual kembali akses akun tanpa izin resmi dari manajemen platform.</li>
                        </ul>

                        <h3>3. Akun dan Keamanan Data</h3>
                        <p>Anda bertanggung jawab penuh atas keamanan password dan aktivitas yang terjadi di bawah akun Anda. <strong>{{ $settings['app_name'] ?? 'Kami' }}</strong> berkomitmen menjaga data di server, namun kegagalan keamanan akibat kelalaian kredensial pengguna di luar tanggung jawab kami.</p>

                        <h3>4. Pembayaran dan Langganan</h3>
                        <p>Sistem operasional kami mengikuti aturan berikut:</p>
                        <ul>
                            <li><strong>Prabayar:</strong> Layanan diaktifkan setelah pembayaran paket (bulanan/tahunan) dikonfirmasi.</li>
                            <li><strong>Kebijakan Refund:</strong> Biaya yang sudah dibayarkan tidak dapat ditarik kembali kecuali terjadi kegagalan sistem total dari sisi kami.</li>
                            <li><strong>Masa Tenggang:</strong> Jika pembayaran jatuh tempo tidak dipenuhi, akses ke dashboard admin akan ditangguhkan sementara hingga pelunasan dilakukan.</li>
                        </ul>

                        <h3>5. Batasan Tanggung Jawab</h3>
                        <p>Kami berupaya menjaga ketersediaan sistem (uptime) hingga 99.9%. Namun, kami tidak bertanggung jawab atas kerugian finansial koperasi yang disebabkan oleh gangguan teknis pihak ketiga (seperti provider internet atau mati listrik lokal) atau kesalahan input data oleh admin koperasi.</p>

                        <h3>6. Perubahan Ketentuan</h3>
                        <p>Syarat dan ketentuan ini dapat berubah sewaktu-waktu seiring dengan perkembangan fitur aplikasi. Perubahan akan diinformasikan melalui dashboard admin atau email resmi terdaftar.</p>

                        <div class="mt-5 pt-4 border-top">
                            <p class="small text-muted mb-0">
                                Jika ada bagian dari syarat ini yang kurang dipahami, silakan hubungi tim legal kami di 
                                <a href="mailto:{{ $settings['company_email'] ?? 'support@kopdes.id' }}" class="fw-bold text-primary">{{ $settings['company_email'] ?? 'support@kopdes.id' }}</a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection