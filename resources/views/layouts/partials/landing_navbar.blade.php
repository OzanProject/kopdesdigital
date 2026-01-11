<style>
    .navbar-modern {
        transition: all 0.3s ease;
        padding-top: 1.2rem;
        padding-bottom: 1.2rem;
    }

    .nav-link {
        font-weight: 500;
        color: #64748b !important; /* Slate color yang modern */
        transition: all 0.2s ease;
        position: relative;
        padding: 0.5rem 1rem !important;
    }

    .nav-link:hover, .nav-link.active {
        color: var(--primary-color) !important;
    }

    /* Efek garis bawah pada hover */
    @media (min-width: 992px) {
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link:hover::after, .nav-link.active::after {
            width: 30%;
        }
    }

    .btn-login {
        color: var(--primary-color);
        font-weight: 600;
        border: none;
        background: transparent;
    }

    .btn-register {
        box-shadow: 0 4px 14px 0 rgba(0, 97, 255, 0.2);
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top navbar-modern shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="{{ route('home') }}">
             @php $saasLogo = $settings['app_logo'] ?? null; @endphp
             @if($saasLogo)
                <img src="{{ asset('storage/' . $saasLogo) }}" alt="Logo" height="40" class="me-2">
             @endif
             <span style="letter-spacing: -0.5px;">{{ $settings['app_name'] ?? 'KopDes Digital' }}</span>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('landing.features') ? 'active' : '' }}" href="{{ route('landing.features') }}">Fitur</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('landing.pricing') ? 'active' : '' }}" href="{{ route('landing.pricing') }}">Harga</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('landing.testimonials') ? 'active' : '' }}" href="{{ route('landing.testimonials') }}">Testimoni</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('landing.faq') ? 'active' : '' }}" href="{{ route('landing.faq') }}">FAQ</a>
                </li>
                
                <li class="nav-item ms-lg-4 mt-4 mt-lg-0 w-100 w-lg-auto">
                    <div class="d-flex flex-column flex-lg-row align-items-center gap-2">
                        <a href="{{ route('login') }}" class="btn btn-login px-4 py-2 w-100 w-lg-auto">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-register px-4 py-2 rounded-pill w-100 w-lg-auto">
                            Daftar Sekarang
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>