<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>@hasSection('title') @yield('title') — @endif {{ $settings['app_name'] ?? config('app.name') }}</title>
    <meta name="description" content="{{ $settings['seo_meta_description'] ?? '' }}">
    <meta name="keywords" content="{{ $settings['seo_meta_keywords'] ?? '' }}">
    
    @php $saasLogo = $settings['app_logo'] ?? null; @endphp
    <link rel="icon" type="image/x-icon" href="{{ $saasLogo ? asset('storage/' . $saasLogo) : asset('img/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #0061ff;
            --secondary-color: #60a5fa;
            --dark-blue: #0f172a;
            --light-bg: #f8fafc;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--light-bg); 
            color: #334155;
            overflow-x: hidden;
        }

        /* Hero Section Modern */
        .hero-section { 
            padding: 140px 0 100px; 
            background: radial-gradient(circle at top right, #e0eaff 0%, #ffffff 50%);
            position: relative;
        }

        /* Utility Classes for Professional Look */
        .section-padding { padding: 100px 0; }
        
        .card-feature { 
            border: 1px solid rgba(0,0,0,0.05); 
            border-radius: 24px; 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
            background: white;
            padding: 2rem;
        }
        
        .card-feature:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            border-color: var(--primary-color);
        }

        .icon-box { 
            width: 64px; 
            height: 64px; 
            background: rgba(0, 97, 255, 0.1); 
            color: var(--primary-color); 
            border-radius: 18px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 26px; 
            margin-bottom: 24px; 
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: #0052d4;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 97, 255, 0.3);
        }

        /* Navbar Customization */
        .navbar {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.8);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
    </style>

    {!! $settings['seo_head_scripts'] ?? '' !!}
</head>
<body>

    @include('layouts.partials.landing_navbar')

    <main>
        @yield('content')
    </main>

    @include('layouts.partials.landing_footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-sm');
            } else {
                nav.classList.remove('shadow-sm');
            }
        });
    </script>
</body>
</html>