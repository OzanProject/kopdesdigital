<section id="features" class="section-padding bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase ls-2">Fitur Unggulan</h6>
            <h2 class="fw-bold">Kenapa Memilih Kami?</h2>
        </div>
        <div class="row g-4">
            @foreach($features as $feature)
            <div class="col-md-6 col-lg-3">
                <div class="card card-feature h-100 p-4 text-center bg-white">
                    <div class="icon-box mx-auto">
                        <i class="{{ $feature->icon ?? 'fas fa-check' }}"></i>
                    </div>
                    <h5 class="fw-bold mb-3">{{ $feature->title }}</h5>
                    <p class="text-muted small mb-0">{{ $feature->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
