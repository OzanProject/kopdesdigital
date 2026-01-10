<section id="faq" class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase ls-2">Pusat Bantuan</h6>
            <h2 class="fw-bold">Pertanyaan yang Sering Diajukan</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    @foreach($faqs as $index => $faq)
                    <div class="accordion-item border-0 mb-3 shadow-sm rounded overflow-hidden">
                        <h2 class="accordion-header" id="flush-heading{{ $index }}">
                            <button class="accordion-button {{ $index != 0 ? 'collapsed' : '' }} fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="flush-collapse{{ $index }}">
                                {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="flush-collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="flush-heading{{ $index }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
