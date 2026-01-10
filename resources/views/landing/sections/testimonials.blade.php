<section id="testimonials" class="section-padding bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase ls-2">Apa Kata Mereka</h6>
            <h2 class="fw-bold">Testimoni Pengguna</h2>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($testimonials as $testimonial)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm p-4">
                    <div class="d-flex align-items-center mb-3">
                        @if($testimonial->avatar)
                            <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->name }}" class="testimonial-img me-3">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($testimonial->name) }}&background=0d6efd&color=fff" alt="{{ $testimonial->name }}" class="testimonial-img me-3">
                        @endif
                        <div>
                            <h6 class="fw-bold mb-0">{{ $testimonial->name }}</h6>
                            <small class="text-muted">{{ $testimonial->role }}</small>
                        </div>
                    </div>
                    <div class="mb-3 text-warning">
                        @for($i=1; $i<=5; $i++)
                            <i class="fas fa-star {{ $i <= $testimonial->rating ? '' : 'text-muted opacity-25' }}"></i>
                        @endfor
                    </div>
                    <p class="text-muted mb-0 fst-italic">"{{ $testimonial->content }}"</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
