<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - {{ \App\Models\SaasSetting::where('key', 'app_name')->value('value') ?? config('app.name') }}</title>
    
    @php
        $settings = \App\Models\SaasSetting::pluck('value', 'key')->toArray();
        $appName = $settings['app_name'] ?? config('app.name');
        $logo = $settings['app_logo'] ?? null;
        $favUrl = $logo ? asset('storage/' . $logo) : asset('adminlte3/dist/img/AdminLTELogo.png');
    @endphp

    <link rel="icon" href="{{ $favUrl }}" type="image/png">
    
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

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            flex-wrap: wrap;
        }

        /* Sisi Kiri: Branding */
        .auth-left {
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

        .support-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 24px;
            margin-top: 40px;
        }

        /* Sisi Kanan: Form */
        .auth-right {
            flex: 1 0 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
            background: white;
        }

        .auth-form-container {
            width: 100%;
            max-width: 400px;
        }

        .form-floating > .form-control {
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .form-floating > .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }

        .btn-reset {
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            background: var(--primary-blue);
            border: none;
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.15);
            transition: all 0.3s ease;
        }

        .btn-reset:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(13, 110, 253, 0.25);
            background: #0b5ed7;
        }

        @media (max-width: 991.98px) {
            .auth-left { display: none; }
            .auth-right { flex: 1 0 100%; padding: 40px 20px; }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-left">
        <div class="decoration-circle circle-1"></div>
        <div class="decoration-circle circle-2"></div>
        
        <div class="position-relative" style="z-index: 2; max-width: 500px;">
            <div class="mb-5">
                @if($logo)
                    <img src="{{ asset('storage/'.$logo) }}" alt="Logo" height="45" class="bg-white rounded p-2 mb-3 shadow-sm">
                @endif
                <h3 class="fw-bold ls-1">{{ $appName }}</h3>
            </div>

            <h1 class="display-5 fw-800 mb-4" style="font-weight: 800; line-height: 1.2;">Lupa Password? <br>Kami Siap Membantu.</h1>
            <p class="opacity-75 mb-4 fs-5">Jangan khawatir, keamanan akun Anda adalah prioritas kami. Cukup masukkan email Anda untuk memulai proses pemulihan.</p>
            
            <div class="support-card d-flex align-items-center">
                <div class="icon-circle bg-white bg-opacity-20 rounded-circle p-3 me-3">
                    <i class="fas fa-headset fa-2x"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0">Butuh Bantuan Cepat?</h6>
                    <small class="opacity-75">Hubungi tim support kami kapan saja.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-form-container">
            <div class="mb-5">
                <h2 class="fw-bold text-dark ls-1">Atur Ulang Kata Sandi</h2>
                <p class="text-muted">Masukkan email yang terdaftar untuk menerima tautan pemulihan.</p>
            </div>

            @if(session('status'))
                <div class="alert alert-success border-0 rounded-3 mb-4 small animate__animated animate__fadeIn">
                    <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-3 mb-4 small animate__animated animate__shakeX">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-floating mb-4">
                    <input type="email" class="form-control" id="email" name="email" placeholder="nama@koperasi.id" value="{{ old('email') }}" required autofocus>
                    <label for="email">Alamat Email Terdaftar</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-reset text-white mb-4">
                    Kirim Link Pemulihan <i class="fas fa-paper-plane ms-2"></i>
                </button>
                
                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-decoration-none fw-bold small">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Halaman Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>