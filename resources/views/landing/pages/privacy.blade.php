@extends('layouts.landing')

@section('title', 'Kebijakan Privasi')

@section('content')
<style>
    /* Styling khusus untuk halaman konten legal */
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
        margin-top: -40px; /* Menarik kartu ke atas sedikit */
        position: relative;
        z-index: 10;
    }
    .content-body h3 {
        color: #0f172a;
        font-weight: 700;
        font-size: 1.25rem;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }
    /* Memberikan nomor otomatis pada H3 jika diinginkan secara visual */
    .content-body p, .content-body li {
        color: #475569;
        line-height: 1.8;
        font-size: 1.05rem;
    }
    .content-body ul {
        padding-left: 1.2rem;
        margin-bottom: 1.5rem;
    }
    .content-body li {
        margin-bottom: 0.5rem;
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
</style>

<div class="legal-header">
    <div class="container text-center">
        <div class="last-updated mb-3">Terakhir diperbarui: {{ date('d F Y') }}</div>
        <h1 class="fw-extrabold display-4 text-dark mb-0">Kebijakan Privasi</h1>
    </div>
</div>

<div class="container pb-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="legal-card">
                <div class="content-body">
                    @if(!empty($settings['privacy_content']))
                        {!! $settings['privacy_content'] !!}
                    @else
                        {{-- Professional Default Content --}}
                        <p class="lead">Selamat datang di <strong>{{ $settings['app_name'] ?? 'KopDes Digital' }}</strong>. Kami menghargai privasi Anda dan berkomitmen untuk melindungi data pribadi Anda sesuai dengan standar keamanan industri dan regulasi yang berlaku (termasuk UU PDP Indonesia).</p>

                        <h3>1. Pendahuluan</h3>
                        <p>Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan menjaga informasi Anda saat Anda menggunakan platform SaaS kami. Dengan menggunakan layanan kami, Anda menyetujui praktik yang dijelaskan dalam kebijakan ini.</p>

                        <h3>2. Informasi yang Kami Kumpulkan</h3>
                        <p>Saat Anda menggunakan layanan SaaS kami, kami dapat mengumpulkan jenis informasi berikut:</p>
                        <ul>
                            <li><strong>Identitas Pribadi:</strong> Nama, Alamat Email, Nomor Telepon, dan data Koperasi untuk keperluan otentikasi.</li>
                            <li><strong>Data Transaksi:</strong> Data keuangan yang Anda input ke dalam sistem untuk keperluan operasional koperasi Anda.</li>
                            <li><strong>Log Files:</strong> Catatan teknis seperti alamat IP, tipe browser, dan waktu akses untuk keamanan dan pemeliharaan sistem.</li>
                        </ul>

                        <h3>3. Cookies dan Web Beacons</h3>
                        <p>Kami menggunakan 'cookies' untuk meningkatkan pengalaman Anda. Cookies membantu kami memahami preferensi Anda, menjaga sesi login Anda tetap aman, dan mengoptimalkan kinerja aplikasi kami.</p>
                        
                        <h3>4. Penggunaan Informasi</h3>
                        <p>Informasi yang kami kumpulkan digunakan secara ketat untuk:</p>
                        <ul>
                            <li>Menyediakan, mengoperasikan, dan memelihara infrastruktur platform.</li>
                            <li>Meningkatkan fitur dan fungsionalitas berdasarkan umpan balik pengguna.</li>
                            <li>Mengirimkan notifikasi penting terkait akun, tagihan, dan pembaruan sistem.</li>
                            <li>Mendeteksi dan mencegah aktivitas ilegal atau pelanggaran keamanan.</li>
                        </ul>

                        <h3>5. Keamanan Data</h3>
                        <p>Kami menerapkan standar keamanan tinggi termasuk enkripsi <strong>SSL/TLS</strong> untuk semua transmisi data dan penyimpanan basis data yang terproteksi firewall. Kami melakukan audit keamanan secara berkala untuk memastikan data koperasi Anda tetap aman.</p>

                        <h3>6. Hak Perlindungan Data Anda</h3>
                        <p>Sesuai dengan regulasi yang berlaku, Anda memiliki hak penuh untuk mengakses data Anda, meminta perbaikan jika terjadi kesalahan, atau meminta penghapusan data (Hak untuk Dilupakan) sesuai dengan prosedur penutupan akun kami.</p>

                        <h3>7. Kontak Kami</h3>
                        <p>Jika Anda memiliki pertanyaan tambahan atau memerlukan informasi lebih lanjut tentang Kebijakan Privasi kami, tim kami siap membantu melalui:</p>
                        
                        <div class="bg-light p-4 rounded-4 mt-4 border">
                            <div class="d-flex align-items-center">
                                <div class="icon-box m-0 me-3" style="width: 50px; height: 50px; min-width: 50px;">
                                    <i class="fas fa-envelope-open-text"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Email Dukungan Privasi</h6>
                                    <a href="mailto:{{ $settings['company_email'] ?? 'support@kopdes.id' }}" class="text-decoration-none fw-bold">{{ $settings['company_email'] ?? 'support@kopdes.id' }}</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection