<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Tambahan penting untuk keamanan AJAX --}}

    <title>
        {{ auth()->user()->hasRole('super_admin') 
            ? (\App\Models\SaasSetting::where('key', 'app_name')->value('value') ?? 'SaaS Super Admin') 
            : ($koperasi->nama ?? config('app.name')) 
        }} | @yield('title')
    </title>

    @php 
        $saasLogo = \App\Models\SaasSetting::where('key', 'app_logo')->value('value');
        $faviconPath = !auth()->user()->hasRole('super_admin') && isset($koperasi) && $koperasi->logo 
            ? asset('storage/' . $koperasi->logo) 
            : ($saasLogo ? asset('storage/' . $saasLogo) : asset('adminlte3/dist/img/AdminLTELogo.png'));
    @endphp
    
    <link rel="icon" type="image/x-icon" href="{{ $faviconPath }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte3/dist/css/adminlte.min.css') }}">
    
    <style>
        /* Modernisasi Global Dashboard */
        body { font-family: 'Inter', 'Source Sans Pro', sans-serif; }
        .content-wrapper { background-color: #f4f6f9; }
        .main-sidebar { box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .content-header h1 { font-weight: 800; color: #1e293b; font-size: 1.8rem; }
        .breadcrumb-item a { color: #0d6efd; font-weight: 500; }
        
        /* Utility Classes */
        .rounded-lg { border-radius: 12px !important; }
        .shadow-sm { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }
        .ls-1 { letter-spacing: 0.5px; }
    </style>

    @stack('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    {{-- Navbar --}}
    @include('layouts.partials.navbar')

    {{-- Sidebar --}}
    @include('layouts.partials.sidebar')

    <div class="content-wrapper">
        <section class="content-header py-4">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right bg-transparent p-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                {{-- Di sini konten dari setiap halaman akan muncul --}}
                @yield('content')
            </div>
        </section>
    </div>

    {{-- Footer --}}
    @include('layouts.partials.footer')

</div>
<script src="{{ asset('adminlte3/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte3/dist/js/adminlte.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // CSRF Token Setup untuk AJAX (Mencegah error 419)
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        // Flash Message Logic (Variabel PHP ke JS yang Aman)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#0d6efd'
            });
        @endif

        // Global Delete Confirmation (Hanya untuk class .btn-delete)
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus data ini secara permanen?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@stack('js')
</body>
</html>