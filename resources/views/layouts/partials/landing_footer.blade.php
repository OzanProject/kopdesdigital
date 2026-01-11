<style>
    .footer-modern {
        background-color: #0f172a; /* Warna Navy Slate yang lebih premium */
        color: #94a3b8;
        font-size: 0.9rem;
    }

    .footer-modern h5, .footer-modern h6 {
        color: #ffffff;
        letter-spacing: 0.5px;
    }

    .footer-link {
        color: #94a3b8;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
        margin-bottom: 0.5rem;
    }

    .footer-link:hover {
        color: var(--primary-color) !important;
        transform: translateX(5px);
    }

    .footer-contact-item {
        display: flex;
        align-items: start;
        gap: 12px;
        margin-bottom: 1rem;
    }

    .footer-contact-icon {
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        flex-shrink: 0;
    }

    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        padding-top: 2rem;
        margin-top: 3rem;
    }
</style>

<footer class="footer-modern pt-5 pb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <h5 class="fw-bold mb-3 d-flex align-items-center">
                    @php $saasLogo = $settings['app_logo'] ?? null; @endphp
                    @if($saasLogo)
                        <img src="{{ asset('storage/' . $saasLogo) }}" alt="Logo" height="30" class="me-2 brightness-0 invert">
                    @endif
                    {{ $settings['app_name'] ?? 'KopDes Digital' }}
                </h5>
                <p class="mb-4 lh-lg">
                    {{ $settings['hero_subtitle'] ?? 'Platform manajemen koperasi modern untuk masa depan ekonomi desa yang lebih transparan dan efisien.' }}
                </p>
                @if(isset($settings['company_address']) && $settings['company_address'])
                    <div class="footer-contact-item">
                        <div class="footer-contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <span>{{ $settings['company_address'] }}</span>
                    </div>
                @endif
            </div>

            <div class="col-6 col-md-3 col-lg-2 mb-4">
                <h6 class="fw-bold mb-4 text-uppercase small">Tautan</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="footer-link">Beranda</a></li>
                    <li><a href="{{ route('landing.features') }}" class="footer-link">Fitur Utama</a></li>
                    <li><a href="{{ route('landing.pricing') }}" class="footer-link">Paket Harga</a></li>
                    <li><a href="{{ route('sitemap') }}" class="footer-link">Sitemap</a></li>
                </ul>
            </div>

            <div class="col-6 col-md-3 col-lg-3 mb-4">
                <h6 class="fw-bold mb-4 text-uppercase small">Legalitas</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('landing.terms') }}" class="footer-link">Syarat & Ketentuan</a></li>
                    <li><a href="{{ route('landing.privacy') }}" class="footer-link">Kebijakan Privasi</a></li>
                    <li><a href="#" class="footer-link">Pusat Bantuan</a></li>
                </ul>
            </div>

            <div class="col-md-6 col-lg-3">
                <h6 class="fw-bold mb-4 text-uppercase small">Hubungi Kami</h6>
                <div class="footer-contact-item">
                    <div class="footer-contact-icon"><i class="fas fa-envelope"></i></div>
                    <span>{{ $settings['company_email'] ?? 'support@kopdes.id' }}</span>
                </div>
                <div class="footer-contact-item">
                    <div class="footer-contact-icon"><i class="fab fa-whatsapp"></i></div>
                    <span>{{ $settings['company_phone'] ?? '+62 812-3456-7890' }}</span>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="opacity-75">&copy; {{ date('Y') }} {{ $settings['app_name'] ?? 'KopDes Digital' }}. All rights reserved.</span>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <span class="badge bg-secondary opacity-50 fw-normal px-3 py-2 rounded-pill">
                        System Version {{ $settings['app_version'] ?? '1.0.0' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>