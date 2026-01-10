@extends('layouts.landing')

@section('title', 'Kebijakan Privasi')

@section('content')
<div class="pt-5 mt-5 container section-padding">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="fw-bold mb-4">Kebijakan Privasi</h1>
            <p class="text-muted mb-5">Terakhir diperbarui: {{ date('d F Y') }}</p>

            <div class="content-body">
                @if(!empty($settings['privacy_content']))
                    {!! $settings['privacy_content'] !!}
                @else
                    {{-- Professional Default Content --}}
                    <h3>1. Pendahuluan</h3>
                    <p>Selamat datang di <strong>{{ $settings['app_name'] ?? 'KopDes Digital' }}</strong>. Kami menghargai privasi Anda dan berkomitmen untuk melindungi data pribadi Anda sesuai dengan standar keamanan industri dan regulasi yang berlaku (termasuk UU PDP Indonesia).</p>

                    <h3>2. Informasi yang Kami Kumpulkan</h3>
                    <p>Saat Anda menggunakan layanan SaaS kami, kami dapat mengumpulkan jenis informasi berikut:</p>
                    <ul>
                        <li><strong>Identitas Pribadi:</strong> Nama, Alamat Email, Nomor Telepon, dan data Koperasi (untuk pendaftaran akun).</li>
                        <li><strong>Data Transaksi:</strong> Data keuangan yang Anda input ke dalam sistem untuk keperluan pembukuan koperasi.</li>
                        <li><strong>Log Files:</strong> Seperti standar prosedur website lainnya, kami menggunakan log files yang mencatat pengunjung (IP address, tipe browser, ISP, tanggal/waktu). Tujuannya untuk analisis tren dan administrasi sistem.</li>
                    </ul>

                    <h3>3. Cookies dan Web Beacons</h3>
                    <p>Seperti website modern lainnya, {{ $settings['app_name'] ?? 'platform' }} menggunakan 'cookies'. Cookies ini digunakan untuk menyimpan preferensi pengunjung dan melacak otentikasi sesi Anda agar Anda tetap login dengan aman.</p>
                    
                    <h3>4. Google DoubleClick DART Cookie</h3>
                    <p>Google adalah vendor pihak ketiga di situs kami. Google juga menggunakan cookies, yang dikenal sebagai DART cookies, untuk menayangkan iklan kepada pengunjung situs kami berdasarkan kunjungan mereka ke situs kami dan situs lain di internet.</p>

                    <h3>5. Penggunaan Informasi</h3>
                    <p>Informasi yang kami kumpulkan digunakan untuk:</p>
                    <ul>
                        <li>Menyediakan, mengoperasikan, dan memelihara website kami.</li>
                        <li>Meningkatkan layanan dan pengalaman pengguna.</li>
                        <li>Mengirimkan email terkait layanan (tagihan, pembaruan sistem, reset password).</li>
                        <li>Mencegah penipuan dan menjaga keamanan sistem.</li>
                    </ul>

                    <h3>6. Keamanan Data</h3>
                    <p>Kami menerapkan enkripsi SSL/TLS dan firewall untuk melindungi data Anda. Namun, perlu diingat bahwa tidak ada metode transmisi via internet yang 100% aman, meskipun kami berupaya sebaik mungkin untuk melindunginya.</p>

                    <h3>7. Hak Perlindungan Data Anda</h3>
                    <p>Kami ingin memastikan Anda sepenuhnya menyadari hak perlindungan data Anda. Setiap pengguna berhak atas: Hak akses, Hak perbaikan, Hak penghapusan, dan Hak pembatasan pemrosesan.</p>

                    <h3>8. Persetujuan</h3>
                    <p>Dengan menggunakan situs web kami, Anda dengan ini menyetujui Kebijakan Privasi kami dan menyetujui Syarat dan Ketentuannya.</p>

                    <h3>9. Kontak</h3>
                    <p>Jika Anda memiliki pertanyaan tambahan atau memerlukan informasi lebih lanjut tentang Kebijakan Privasi kami, jangan ragu untuk menghubungi kami melalui email di <strong>{{ $settings['company_email'] ?? 'support@kopdes.id' }}</strong>.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
