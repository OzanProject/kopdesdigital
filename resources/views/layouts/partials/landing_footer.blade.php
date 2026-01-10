<footer class="bg-dark text-white pt-5 pb-3">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">{{ $settings['app_name'] ?? 'KopDes Digital' }}</h5>
                <p class="text-white-50 small">
                    {{ $settings['hero_subtitle'] ?? 'Platform manajemen koperasi modern untuk masa depan ekonomi desa.' }}
                </p>
                @if(isset($settings['company_address']) && $settings['company_address'])
                    <p class="text-white-50 small mt-3"><i class="fas fa-map-marker-alt me-2"></i> {{ $settings['company_address'] }}</p>
                @endif
            </div>
            <div class="col-md-2 mb-4">
                <h6 class="fw-bold mb-3">Tautan</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                    <li><a href="{{ route('landing.features') }}" class="text-white-50 text-decoration-none">Fitur</a></li>
                    <li><a href="{{ route('landing.pricing') }}" class="text-white-50 text-decoration-none">Harga</a></li>
                    <li><a href="{{ route('sitemap') }}" class="text-white-50 text-decoration-none">Sitemap</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold mb-3">Legal</h6>
                <ul class="list-unstyled small">
                    <li><a href="{{ route('landing.terms') }}" class="text-white-50 text-decoration-none">Syarat & Ketentuan</a></li>
                    <li><a href="{{ route('landing.privacy') }}" class="text-white-50 text-decoration-none">Kebijakan Privasi</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold mb-3">Hubungi Kami</h6>
                <p class="text-white-50 small">
                    Email: {{ $settings['company_email'] ?? 'support@kopdes.id' }}<br>
                    WhatsApp: {{ $settings['company_phone'] ?? '+62 812-3456-7890' }}
                </p>
            </div>
        </div>
        <hr class="border-secondary">
        <div class="text-center text-white-50 small">
            &copy; {{ date('Y') }} {{ $settings['app_name'] ?? 'KopDes Digital' }}. All rights reserved. <br>
            Version {{ $settings['app_version'] ?? '1.0.0' }}
        </div>
    </div>
</footer>
