<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ \App\Models\SaasSetting::where('key', 'app_name')->value('value') ?? config('app.name') }}</title>
    
    <!-- Open Graph / SEO -->
    @php
        $settings = \App\Models\SaasSetting::pluck('value', 'key')->toArray();
        $appName = $settings['app_name'] ?? config('app.name');
        
        // Define Default Logo (AdminLTE)
        $defaultLogo = asset('adminlte3/dist/img/AdminLTELogo.png');
        
        // Logic: OG Image -> SEO Image > App Logo > Default
        if (isset($settings['seo_og_image'])) {
            $ogImage = asset('storage/' . $settings['seo_og_image']);
        } elseif (isset($settings['app_logo'])) {
            $ogImage = asset('storage/' . $settings['app_logo']);
        } else {
            $ogImage = $defaultLogo;
        }

        // Logic: Favicon -> Favicon > App Logo > Default
        $favicon = $settings['favicon'] ?? null;
        $appLogo = $settings['app_logo'] ?? null;

        if ($favicon) {
            $favUrl = asset('storage/' . $favicon);
        } elseif ($appLogo) {
            $favUrl = asset('storage/' . $appLogo);
        } else {
            $favUrl = $defaultLogo;
        }
        $favType = 'image/png'; 
    @endphp
    <meta property="og:title" content="Login - {{ $appName }}">
    <meta property="og:description" content="Login ke dalam sistem aplikasi {{ $appName }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ $favUrl }}?v={{ time() }}" type="{{ $favType }}">
    <link rel="shortcut icon" href="{{ $favUrl }}?v={{ time() }}" type="{{ $favType }}">
    <link rel="apple-touch-icon" href="{{ $favUrl }}?v={{ time() }}">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; height: 100vh; overflow: hidden; }
        .login-container { height: 100vh; }
        .login-left {
            background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px;
            position: relative;
        }
        .login-right {
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px;
        }
        .login-form-wrapper { width: 100%; max-width: 400px; }
        .form-floating > .form-control:focus ~ label { color: #0d6efd; }
        .form-control:focus { border-color: #8bb9fe; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); }
        .btn-primary { padding: 12px; font-weight: 600; border-radius: 8px; }
        .decoration-circle {
            position: absolute;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        /* Illustrations/Decorations */
        .circle-1 { width: 200px; height: 200px; top: -50px; left: -50px; }
        .circle-2 { width: 300px; height: 300px; bottom: -100px; right: -50px; }
    </style>
</head>
<body>

<div class="container-fluid login-container">
    <div class="row h-100">
        <!-- Left Side: Branding -->
        <div class="col-lg-6 d-none d-lg-flex login-left">
            <div class="decoration-circle circle-1"></div>
            <div class="decoration-circle circle-2"></div>
            
            <div class="position-relative z-1">
                <div class="mb-4">
                    <!-- Logo Placeholder or Dynamic Logo -->
                    @php $logo = \App\Models\SaasSetting::where('key', 'app_logo')->value('value'); @endphp
                    @if($logo)
                        <img src="{{ asset('storage/'.$logo) }}" alt="Logo" height="60" class="mb-3 bg-white rounded p-2">
                    @endif
                </div>
                <h1 class="fw-bold mb-3">Selamat Datang Kembali!</h1>
                <p class="lead mb-4 op-75">Kelola koperasi Anda dengan lebih mudah, transparan, dan profesional bersama platform kami.</p>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex bg-white bg-opacity-10 rounded p-3 align-items-center">
                        <i class="fas fa-shield-alt fa-2x me-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Aman & Terpercaya</h6>
                            <small class="text-white-50">Enkripsi Data Bank-Grade</small>
                        </div>
                    </div>
                    <div class="d-flex bg-white bg-opacity-10 rounded p-3 align-items-center">
                        <i class="fas fa-cloud fa-2x me-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Cloud Based</h6>
                            <small class="text-white-50">Akses Dari Mana Saja</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="col-lg-6 login-right">
            <div class="login-form-wrapper">
                <div class="mb-5 text-center text-lg-start">
                    <h2 class="fw-bold text-dark">Masuk Akun</h2>
                    <p class="text-muted">Silakan masukkan kredensial Anda untuk melanjutkan.</p>
                </div>

                <!-- Session Status -->
                @if(session('status'))
                    <div class="alert alert-success mb-4 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                        <label for="email">Alamat Email</label>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                        <label for="password">Password</label>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                            <label class="form-check-label text-muted" for="remember_me">
                                Ingat Saya
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none small fw-bold">Lupa Password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-lg shadow-sm mb-3">
                        Masuk Dashboard <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted small">Belum punya akun? <a href="{{ route('register') }}" class="fw-bold text-decoration-none">Daftar Koperasi Baru</a></p>
                        <hr>
                        <p class="text-muted small mt-3"><a href="{{ route('home') }}" class="text-decoration-none text-secondary"><i class="fas fa-home me-1"></i> Kembali ke Beranda</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
