<section id="hero" class="hero-section d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">{{ $settings['hero_title'] ?? 'Judul Hero Default' }}</h1>
                <p class="lead mb-4">{{ $settings['hero_subtitle'] ?? 'Subjudul default untuk menjelaskan value proposition aplikasi Anda.' }}</p>
                <div class="d-flex gap-3">
                    <a href="{{ $settings['hero_cta_link'] ?? route('register') }}" class="btn btn-light btn-lg text-primary fw-bold px-4 shadow-sm">
                        {{ $settings['hero_cta_text'] ?? 'Mulai Sekarang' }}
                    </a>
                    <a href="{{ route('landing.features') }}" class="btn btn-outline-light btn-lg px-4">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0 text-center">
                @if(isset($settings['hero_image']))
                    <img src="{{ asset('storage/' . $settings['hero_image']) }}" alt="Hero Image" class="img-fluid rounded-3 shadow-lg animation-float" style="max-height: 400px;">
                @else
                    <img src="{{ asset('img/undraw_dashboard.svg') }}" alt="Default Hero" class="img-fluid" style="max-height: 400px;">
                @endif
            </div>
        </div>
    </div>
</section>
