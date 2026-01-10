<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Dynamic SEO Meta Tags -->
    <title>@hasSection('title') @yield('title') - @endif {{ $settings['app_name'] ?? config('app.name') }}</title>
    <meta name="description" content="{{ $settings['seo_meta_description'] ?? '' }}">
    <meta name="keywords" content="{{ $settings['seo_meta_keywords'] ?? '' }}">
    
    <!-- OG Meta Tags -->
    @if(isset($settings['seo_og_image']))
    <meta property="og:image" content="{{ asset('storage/'.$settings['seo_og_image']) }}">
    @endif

    <!-- Favicon -->
    @php $saasLogo = $settings['app_logo'] ?? null; @endphp
    <link rel="icon" type="image/x-icon" href="{{ $saasLogo ? asset('storage/' . $saasLogo) : asset('img/AdminLTELogo.png') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .hero-section { padding: 100px 0; background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%); color: white; }
        .section-padding { padding: 80px 0; }
        .card-feature { border: none; border-radius: 15px; transition: transform 0.3s; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .card-feature:hover { transform: translateY(-5px); }
        .icon-box { width: 60px; height: 60px; background: #e7f1ff; color: #0d6efd; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 20px; }
        .pricing-card { border: none; border-radius: 20px; transition: 0.3s; }
        .pricing-card:hover { transform: scale(1.05); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .testimonial-img { width: 60px; height: 60px; object-fit: cover; border-radius: 50%; }
        .accordion-button:not(.collapsed) { background-color: #e7f1ff; color: #0d6efd; }
    </style>

    <!-- Header Scripts (Analytics etc) -->
    {!! $settings['seo_head_scripts'] ?? '' !!}
</head>
<body>

    @include('layouts.partials.landing_navbar')

    @yield('content')

    @include('layouts.partials.landing_footer')

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
