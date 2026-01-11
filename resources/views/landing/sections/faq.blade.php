<style>
    .faq-accordion .accordion-item {
        border: 1px solid #f1f5f9 !important;
        margin-bottom: 1rem;
        border-radius: 16px !important;
    }
    .faq-accordion .accordion-button {
        padding: 1.5rem;
        background-color: transparent;
        color: #0f172a;
        box-shadow: none;
    }
    .faq-accordion .accordion-button:not(.collapsed) {
        color: var(--primary-color);
        border-bottom: 1px solid #f1f5f9;
    }
</style>

<section id="faq" class="section-padding bg-light">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-6">
                <h6 class="text-primary fw-bold text-uppercase ls-2">FAQ</h6>
                <h2 class="fw-bold">Punya Pertanyaan?</h2>
                <p class="text-muted">Berikut adalah jawaban untuk pertanyaan yang paling sering diajukan pelanggan kami.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion faq-accordion" id="faqAccordion">
                    @foreach($faqs as $index => $faq)
                    <div class="accordion-item shadow-sm overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $index != 0 ? 'collapsed' : '' }} fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}">
                                {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body lh-lg opacity-75">
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