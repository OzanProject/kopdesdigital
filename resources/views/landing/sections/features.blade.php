<style>
    .features-section {
        background: #ffffff;
        position: relative;
    }

    .ls-2 {
        letter-spacing: 2px;
        font-size: 0.85rem;
    }

    /* Styling Kartu Fitur */
    .card-feature-modern {
        border: 1px solid #f1f5f9;
        border-radius: 24px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: #ffffff;
        position: relative;
        overflow: hidden;
    }

    /* Efek Glow saat Hover */
    .card-feature-modern:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
        border-color: rgba(13, 110, 253, 0.2);
    }

    /* Styling Box Ikon */
    .icon-box-modern {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.1) 0%, rgba(13, 110, 253, 0.05) 100%);
        color: #0d6efd;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 25px;
        transition: all 0.3s ease;
    }

    .card-feature-modern:hover .icon-box-modern {
        background: #0d6efd;
        color: white;
        transform: rotate(-5deg) scale(1.1);
    }

    .feature-title {
        font-size: 1.25rem;
        color: #0f172a;
        font-weight: 700;
    }

    .feature-desc {
        color: #64748b;
        line-height: 1.6;
        font-size: 0.95rem;
    }
</style>

<section id="features" class="section-padding features-section">
    <div class="container">
        <div class="text-center mb-5 animate__animated animate__fadeIn">
            <h6 class="text-primary fw-bold text-uppercase ls-2 mb-3">Fitur Unggulan</h6>
            <h2 class="fw-bold display-6" style="color: #0f172a;">Solusi Lengkap untuk Koperasi Modern</h2>
            <div class="mx-auto mt-3" style="width: 60px; height: 4px; background: #0d6efd; border-radius: 2px;"></div>
        </div>

        <div class="row g-4">
            @foreach($features as $feature)
            <div class="col-md-6 col-lg-3">
                <div class="card card-feature-modern h-100 p-4 border-0 shadow-sm">
                    <div class="icon-box-modern">
                        <i class="{{ $feature->icon ?? 'fas fa-shield-alt' }}"></i>
                    </div>
                    <h5 class="feature-title mb-3">{{ $feature->title }}</h5>
                    <p class="feature-desc mb-0">
                        {{ $feature->description ?? 'Kelola data koperasi dengan sistem yang terintegrasi dan aman dalam satu platform.' }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>