<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ route('home') }}">
             @php $saasLogo = $settings['app_logo'] ?? null; @endphp
             @if($saasLogo)
                <img src="{{ asset('storage/' . $saasLogo) }}" alt="Logo" height="40" class="d-inline-block align-text-top me-2">
             @endif
             {{ $settings['app_name'] ?? 'KopDes Digital' }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center text-center">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold text-primary' : '' }}" href="{{ route('home') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('landing.features') ? 'active fw-bold text-primary' : '' }}" href="{{ route('landing.features') }}">Fitur</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('landing.pricing') ? 'active fw-bold text-primary' : '' }}" href="{{ route('landing.pricing') }}">Harga</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('landing.testimonials') ? 'active fw-bold text-primary' : '' }}" href="{{ route('landing.testimonials') }}">Testimoni</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('landing.faq') ? 'active fw-bold text-primary' : '' }}" href="{{ route('landing.faq') }}">FAQ</a></li>
                
                <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary px-4 w-100 w-lg-auto me-lg-2">Login</a>
                </li>
                <li class="nav-item mt-2 mt-lg-0">
                    <a href="{{ route('register') }}" class="btn btn-primary px-4 w-100 w-lg-auto">Daftar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
