<style>
    .testimonial-card {
        border-radius: 20px;
        transition: all 0.3s ease;
        background: #fff;
    }
    .testimonial-img {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        object-fit: cover;
    }
    .quote-icon {
        font-size: 2rem;
        color: var(--primary-color);
        opacity: 0.1;
        position: absolute;
        top: 20px;
        right: 20px;
    }
</style>

<section id="testimonials" class="section-padding bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase ls-2">Testimoni</h6>
            <h2 class="fw-bold">Dipercaya oleh Pengurus Koperasi</h2>
        </div>
        <div class="row g-4">
            @foreach($testimonials as $testimonial)
            <div class="col-md-6 col-lg-4">
                <div class="card testimonial-card h-100 border-0 shadow-sm p-4 position-relative">
                    <i class="fas fa-quote-right quote-icon"></i>
                    <div class="mb-4 text-warning">
                        @for($i=1; $i<=5; $i++)
                            <i class="fas fa-star {{ $i <= $testimonial->rating ? '' : 'text-muted opacity-25' }} small"></i>
                        @endfor
                    </div>
                    <p class="text-dark opacity-75 mb-4 lh-lg">"{{ $testimonial->content }}"</p>
                    <div class="d-flex align-items-center mt-auto">
                        <img src="{{ $testimonial->avatar ? asset('storage/' . $testimonial->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($testimonial->name).'&background=0d6efd&color=fff' }}" alt="{{ $testimonial->name }}" class="testimonial-img me-3 shadow-sm">
                        <div>
                            <h6 class="fw-bold mb-0 small">{{ $testimonial->name }}</h6>
                            <p class="text-primary small mb-0" style="font-size: 0.75rem;">{{ $testimonial->role }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>