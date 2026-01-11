<style>
    /* Upgrade pada section utama */
    .hero-custom {
        padding: 120px 0 100px;
        background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
        position: relative;
        overflow: hidden;
        color: white;
    }

    /* Dekorasi lingkaran cahaya di latar belakang */
    .hero-custom::after {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        top: -100px;
        right: -100px;
        z-index: 0;
    }

    .hero-container {
        position: relative;
        z-index: 1;
    }

    /* Styling Teks Hero */
    .hero-title {
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        font-weight: 800;
        letter-spacing: -1px;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 1.15rem;
        color: rgba(255, 255, 255, 0.85);
        font-weight: 400;
        max-width: 90%;
    }

    /* Styling Tombol Premium */
    .btn-cta-main {
        background: white;
        color: #0d6efd !important;
        border: none;
        padding: 14px 32px;
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .btn-cta-main:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
    }

    .btn-cta-outline {
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 14px 32px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
    }

    .btn-cta-outline:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: white;
        color: white;
    }

    /* Efek gambar melayang yang lebih halus */
    .hero-image-wrapper {
        position: relative;
        perspective: 1000px;
    }

    .hero-img-styled {
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(0,0,0,0.2);
        border: 1px solid rgba(255,255,255,0.2);
        animation: floatAnime 4s ease-in-out infinite;
    }

    @keyframes floatAnime {
        0%, 100% { transform: translateY(0) rotate(0); }
        50% { transform: translateY(-15px) rotate(1deg); }
    }
</style>

<section id="hero" class="hero-custom d-flex align-items-center">
    <div class="container hero-container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h1 class="hero-title mb-4">
                    {{ $settings['hero_title'] ?? 'Digitalisasi Koperasi Jadi Lebih Mudah' }}
                </h1>
                <p class="hero-subtitle mb-5">
                    {{ $settings['hero_subtitle'] ?? 'Kelola anggota, simpanan, dan pinjaman dalam satu sistem SaaS terintegrasi untuk masa depan koperasi Indonesia.' }}
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ $settings['hero_cta_link'] ?? route('register') }}" class="btn btn-cta-main">
                        {{ $settings['hero_cta_text'] ?? 'Mulai Sekarang' }}
                    </a>
                    <a href="{{ route('landing.features') }}" class="btn btn-cta-outline">
                        Pelajari Fitur <i class="fas fa-chevron-right ms-2 small"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-6 text-center">
                <div class="hero-image-wrapper">
                    @if(isset($settings['hero_image']))
                        <img src="{{ asset('storage/' . $settings['hero_image']) }}" alt="Hero Image" class="img-fluid hero-img-styled" style="max-height: 450px;">
                    @else
                        <img src="{{ asset('img/undraw_dashboard.svg') }}" alt="Default Hero" class="img-fluid hero-img-styled" style="max-height: 400px; background: rgba(255,255,255,0.1); padding: 20px;">
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>