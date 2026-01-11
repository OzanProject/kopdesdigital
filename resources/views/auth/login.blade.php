<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - {{ \App\Models\SaasSetting::where('key', 'app_name')->value('value') ?? config('app.name') }}</title>
    
    @php
        $settings = \App\Models\SaasSetting::pluck('value', 'key')->toArray();
        $appName = $settings['app_name'] ?? config('app.name');
        $logo = $settings['app_logo'] ?? null;
    @endphp

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #0d6efd;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* Perbaikan: Menggunakan min-height agar tidak tabrakan saat konten panjang */
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            flex-wrap: wrap;
        }

        /* Sisi Kiri */
        .login-left {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #0043a8 100%);
            color: white;
            flex: 1 0 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }

        .decoration-circle {
            position: absolute;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .circle-1 { width: 400px; height: 400px; top: -100px; left: -100px; }
        .circle-2 { width: 500px; height: 500px; bottom: -150px; right: -100px; }

        .feature-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 20px;
            height: 100%;
        }

        /* Sisi Kanan */
        .login-right {
            flex: 1 0 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
            background: white;
        }

        .login-form-container {
            width: 100%;
            max-width: 400px;
        }

        /* Form Styling */
        .form-control {
            padding: 14px 18px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            margin-bottom: 20px;
        }

        .btn-login {
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            background: var(--primary-blue);
            border: none;
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.15);
        }

        /* Responsivitas: Tumpuk ke bawah di layar kecil */
        @media (max-width: 991.98px) {
            .login-left { display: none; } /* Sembunyikan kiri di mobile agar fokus ke form */
            .login-right { flex: 1 0 100%; padding: 40px 20px; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-left">
        <div class="decoration-circle circle-1"></div>
        <div class="decoration-circle circle-2"></div>
        
        <div class="position-relative" style="z-index: 2; max-width: 500px;">
            <div class="mb-5">
                @if($logo)
                    <img src="{{ asset('storage/'.$logo) }}" alt="Logo" height="45" class="bg-white rounded p-2 mb-3">
                @endif
                <h3 class="fw-bold">{{ $appName }}</h3>
            </div>

            <h1 class="display-5 fw-800 mb-4" style="font-weight: 800; line-height: 1.2;">Modernisasi <br>Koperasi Anda.</h1>
            <p class="opacity-75 mb-5 fs-5">Satu platform terintegrasi untuk mengelola anggota, simpanan, dan pinjaman dengan aman.</p>
            
            <div class="row g-3">
                <div class="col-6">
                    <div class="feature-box">
                        <i class="fas fa-shield-alt mb-3 fs-4"></i>
                        <h6 class="fw-bold">Keamanan</h6>
                        <small class="opacity-75 d-block">Backup harian otomatis.</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="feature-box">
                        <i class="fas fa-chart-line mb-3 fs-4"></i>
                        <h6 class="fw-bold">Laporan</h6>
                        <small class="opacity-75 d-block">Real-time report.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="login-right">
        <div class="login-form-container">
            <div class="mb-5">
                <h2 class="fw-bold text-dark">Selamat Datang</h2>
                <p class="text-muted">Masukkan email dan password untuk masuk.</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="small fw-bold text-muted mb-2">Alamat Email</label>
                    <input type="email" name="email" class="form-control" placeholder="nama@koperasi.id" required autofocus>
                </div>

                <div class="mb-2">
                    <label class="small fw-bold text-muted mb-2">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <div class="d-flex justify-content-between mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember">
                        <label class="form-check-label small text-muted" for="remember">Ingat Saya</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="small text-decoration-none fw-bold">Lupa Password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-login text-white">
                    Masuk Sekarang <i class="fas fa-arrow-right ms-2"></i>
                </button>
                
                <div class="text-center mt-4">
                    <p class="small text-muted">Belum terdaftar? <a href="{{ route('register') }}" class="fw-bold text-decoration-none">Daftar Koperasi</a></p>
                    <hr class="my-4 opacity-25">
                    <a href="{{ route('home') }}" class="text-muted small text-decoration-none">
                        <i class="fas fa-chevron-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>