@extends('layouts.landing')

@section('title', 'Syarat & Ketentuan')

@section('content')
<div class="pt-5 mt-5 container section-padding">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="fw-bold mb-4">Syarat & Ketentuan</h1>
            <p class="text-muted mb-5">Terakhir diperbarui: {{ date('d F Y') }}</p>

            <div class="content-body">
                @if(!empty($settings['terms_content']))
                    {!! $settings['terms_content'] !!}
                @else
                    {{-- Professional Default Content --}}
                    <h3>1. Syarat Penggunaan</h3>
                    <p>Dengan mengakses website <strong>{{ $settings['app_name'] ?? 'KopDes Digital' }}</strong>, Anda setuju untuk terikat dengan syarat layanan ini, semua hukum dan peraturan yang berlaku, dan setuju bahwa Anda bertanggung jawab untuk mematuhi hukum lokal yang berlaku.</p>

                    <h3>2. Lisensi Penggunaan (SaaS)</h3>
                    <p>Izin diberikan kepada Anda untuk menggunakan perangkat lunak ini layanan (SaaS) untuk keperluan manajemen koperasi atau bisnis Anda (komersial maupun non-komersial) sesuai dengan paket langganan yang Anda pilih. Lisensi ini tidak memberikan hak kepada Anda untuk:</p>
                    <ul>
                        <li>Memodifikasi atau menyalin kode sumber (source code) aplikasi;</li>
                        <li>Menggunakan materi untuk tujuan publikasi ulang tanpa izin;</li>
                        <li>Mencoba mendekompilasi atau merekayasa balik perangkat lunak apa pun yang terdapat di situs web kami;</li>
                    </ul>

                    <h3>3. Akun dan Keamanan</h3>
                    <p>Anda bertanggung jawab untuk menjaga kerahasiaan kredensial akun Anda. Anda setuju untuk menerima tanggung jawab atas semua aktivitas yang terjadi di akun Anda. Kami berhak menolak layanan, menghentikan akun, atau membatalkan pesanan atas kebijakan kami sendiri jika ditemukan pelanggaran.</p>

                    <h3>4. Pembayaran dan Langganan</h3>
                    <ul>
                        <li>Layanan kami bersifat prabayar (Prepaid) sesuai periode yang dipilih (bulanan/tahunan).</li>
                        <li>Tidak ada pengembalian uang (Refund) untuk periode berlangganan yang sudah berjalan, kecuali ditentukan lain oleh hukum.</li>
                        <li>Keterlambatan pembayaran dapat mengakibatkan penangguhan sementara akses ke dasbor hingga pembayaran diselesaikan.</li>
                    </ul>

                    <h3>5. Penafian (Disclaimer)</h3>
                    <p>Materi di situs web kami disediakan "apa adanya". Kami tidak membuat jaminan, tersurat maupun tersirat, dan dengan ini menafikan dan menyangkal semua jaminan lainnya, termasuk tanpa batasan, jaminan tersirat atau kondisi kelayakan untuk diperdagangkan, atau kesesuaian untuk tujuan tertentu.</p>
                    
                    <h3>6. Batasan Tanggung Jawab</h3>
                    <p>Dalam keadaan apa pun, {{ $settings['app_name'] ?? 'kami' }} atau pemasok kami tidak bertanggung jawab atas segala kerusakan (termasuk, namun tidak terbatas pada, kerusakan karena hilangnya data atau keuntungan, atau karena gangguan bisnis) yang timbul dari penggunaan atau ketidakmampuan untuk menggunakan materi di situs web kami.</p>

                    <h3>7. Hukum yang Mengatur</h3>
                    <p>Syarat dan ketentuan ini diatur oleh dan ditafsirkan sesuai dengan hukum Negara Republik Indonesia dan Anda secara tidak dapat ditarik kembali tunduk pada yurisdiksi eksklusif pengadilan di lokasi tersebut.</p>

                    <h3>8. Perubahan Ketentuan</h3>
                    <p>Kami dapat merevisi persyaratan layanan ini untuk situs webnya kapan saja tanpa pemberitahuan. Dengan menggunakan situs web ini, Anda setuju untuk terikat dengan versi persyaratan layanan yang berlaku saat itu.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
