<style>
    .cta-section {
        position: relative;
        padding: 100px 0;
        background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
        overflow: hidden;
        border-radius: 0; /* Ubah ke 30px jika ingin CTA berbentuk card besar di tengah halaman */
    }

    /* Dekorasi Latar Belakang */
    .cta-shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        z-index: 0;
    }
    .cta-shape-1 { width: 300px; height: 300px; top: -150px; left: -100px; }
    .cta-shape-2 { width: 400px; height: 400px; bottom: -200px; right: -100px; }

    .cta-content {
        position: relative;
        z-index: 1;
    }

    .cta-title {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 800;
        letter-spacing: -1px;
    }

    .cta-btn {
        background: #ffffff;
        color: #0d6efd !important;
        padding: 18px 45px;
        border-radius: 16px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        border: none;
    }

    .cta-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        background: #f8fafc;
    }

    .op-80 { opacity: 0.8; }
</style>

<section class="cta-section text-white text-center">
    <div class="cta-shape cta-shape-1"></div>
    <div class="cta-shape cta-shape-2"></div>

    <div class="container cta-content">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="cta-title mb-4 animate__animated animate__fadeInUp">
                    {{ $settings['cta_title'] ?? 'Siap Mengelola Koperasi Anda Secara Digital?' }}
                </h2>
                <p class="lead mb-5 op-80 animate__animated animate__fadeInUp" style="animation-delay: 0.1s">
                    {{ $settings['cta_subtitle'] ?? 'Bergabunglah dengan ribuan koperasi modern lainnya. Coba gratis sekarang juga dan rasakan kemudahannya!' }}
                </p>
                <div class="animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                    <a href="{{ route('register') }}" class="btn cta-btn shadow-lg">
                        Daftar Sekarang <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <p class="mt-4 small op-80">
                        <i class="fas fa-check-circle me-2"></i> Tanpa biaya aktivasi awal &bull; 
                        <i class="fas fa-check-circle me-2"></i> Support 24/7
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>