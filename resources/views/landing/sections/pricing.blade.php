<style>
    .pricing-card {
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        transition: all 0.4s ease;
        background: white;
    }
    .pricing-card.featured {
        border: 2px solid var(--primary-color);
        transform: scale(1.05);
        z-index: 2;
    }
    .pricing-card:hover {
        box-shadow: 0 20px 40px rgba(0,0,0,0.05);
    }
    .promo-box {
        background: linear-gradient(45deg, #f0fdf4, #dcfce7);
        border: 1px dashed #22c55e;
        border-radius: 16px;
    }
    .animation-pulse-soft {
        animation: pulse-soft 2s infinite;
    }
    @keyframes pulse-soft {
        0% { transform: scale(1); }
        50% { transform: scale(1.01); }
        100% { transform: scale(1); }
    }
</style>

<section id="pricing" class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase ls-2">Penawaran Harga</h6>
            <h2 class="fw-bold display-6">Pilih Paket Sesuai Kebutuhan</h2>
        </div>

        @if(isset($availableDiscounts) && $availableDiscounts->count() > 0)
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="promo-box p-4 text-center animation-pulse-soft">
                    <h6 class="fw-bold text-success mb-3"><i class="fas fa-bolt me-2"></i> PROMO TERBATAS!</h6>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        @foreach($availableDiscounts as $promo)
                        <div class="bg-white rounded-pill px-4 py-2 shadow-sm border d-flex align-items-center">
                            <code class="text-primary fw-bold fs-5 me-3">{{ $promo->code }}</code>
                            <span class="badge bg-success">
                                @if($promo->type == 'percent') {{ $promo->amount }}% OFF @else -Rp{{ number_format($promo->amount/1000) }}K @endif
                            </span>
                            <button onclick="navigator.clipboard.writeText('{{ $promo->code }}'); alert('Kode disalin!')" class="btn btn-link btn-sm text-muted ms-2 p-0"><i class="fas fa-copy"></i></button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="row justify-content-center g-4">
            @foreach($packages as $package)
            <div class="col-md-6 col-lg-4">
                <div class="card pricing-card h-100 p-4 {{ $loop->last ? 'featured shadow-lg' : 'border-0 shadow-sm' }}">
                    @if($loop->last)
                        <div class="badge bg-primary position-absolute top-0 start-50 translate-middle px-4 py-2 rounded-pill">Paling Populer</div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <div class="mb-4">
                            <h5 class="fw-bold text-dark text-uppercase small mb-4 opacity-50">{{ $package->name }}</h5>
                            <div class="d-flex justify-content-center align-items-baseline">
                                <span class="fs-2 fw-bold text-primary">Rp</span>
                                <span class="display-5 fw-bold text-primary">{{ number_format($package->price, 0, ',', '.') }}</span>
                            </div>
                            <span class="text-muted small">
                                @if($package->duration_days >= 360) / tahun @elseif($package->duration_days >= 30) / bulan @else / {{ $package->duration_days }} hari @endif
                            </span>
                        </div>
                        
                        <ul class="list-unstyled text-start mb-5 flex-grow-1">
                            <li class="mb-3 d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i> 
                                <span><strong>{{ $package->max_members > 0 ? number_format($package->max_members) : 'Unlimited' }}</strong> Anggota</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-3"></i> 
                                <span><strong>{{ $package->max_users > 0 ? $package->max_users : 'Unlimited' }}</strong> Admin</span>
                            </li>
                            <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle text-success me-3"></i> Laporan Keuangan Otomatis</li>
                            <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle text-success me-3"></i> Support Prioritas</li>
                        </ul>

                        <a href="{{ route('register', ['package' => $package->id]) }}" class="btn {{ $loop->last ? 'btn-primary' : 'btn-outline-primary' }} w-100 fw-bold py-3 rounded-pill">
                            Pilih Paket Sekarang
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>