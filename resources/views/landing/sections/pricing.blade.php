<section id="pricing" class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase ls-2">Penawaran Harga</h6>
            <h2 class="fw-bold">Pilih Paket Sesuai Kebutuhan</h2>
        </div>
        <div class="row justify-content-center g-4">
            {{-- Promo Banner --}}
            @if(isset($availableDiscounts) && $availableDiscounts->count() > 0)
            <div class="col-12 mb-4">
                <div class="alert alert-success border-0 shadow-sm text-center animation-pulse">
                    <h5 class="fw-bold mb-2"><i class="fas fa-gift me-2"></i> Promo Spesial Tersedia!</h5>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        @foreach($availableDiscounts as $promo)
                        <div class="bg-white rounded px-3 py-2 text-success border border-success border-dashed">
                            <small class="text-muted d-block text-uppercase" style="font-size: 0.7rem;">Kode Voucher</small>
                            <span class="fw-bold fs-5 user-select-all cursor-pointer" onclick="navigator.clipboard.writeText('{{ $promo->code }}'); alert('Kode disalin!')" title="Klik untuk salin">{{ $promo->code }}</span>
                            <span class="badge bg-success ms-2">
                                @if($promo->type == 'percent') {{ $promo->amount }}% OFF @else Hemat Rp {{ number_format($promo->amount/1000) }}K @endif
                            </span>
                        </div>
                        @endforeach
                    </div>
                    <p class="small mt-2 mb-0 text-dark opacity-75">Gunakan kode di atas saat melakukan pembayaran.</p>
                </div>
            </div>
            @endif

            @foreach($packages as $package)
            <div class="col-md-6 col-lg-4">
                <div class="card pricing-card h-100 text-center p-4 {{ $loop->last ? 'border-primary shadow' : '' }}">
                    @if($loop->last)
                        <div class="badge bg-primary position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill">Populer</div>
                    @endif
                    <div class="card-body">
                        <h5 class="fw-bold text-muted text-uppercase mb-3">{{ $package->name }}</h5>
                        <h1 class="display-5 fw-bold text-primary mb-0">Rp {{ number_format($package->price, 0, ',', '.') }}</h1>
                        <p class="text-muted small mb-4">
                            @if($package->duration_days >= 360)
                                / tahun
                            @elseif($package->duration_days >= 30)
                                / bulan
                            @else
                                / {{ $package->duration_days }} hari
                            @endif
                        </p>
                        
                        <ul class="list-unstyled text-start mb-4 small">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> <strong>{{ $package->max_members > 0 ? number_format($package->max_members) . ' Anggota' : 'Unlimited Anggota' }}</strong></li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> <strong>{{ $package->max_users > 0 ? $package->max_users . ' Admin User' : 'Unlimited Admin' }}</strong></li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Laporan Keuangan</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Support Prioritas</li>
                        </ul>

                        <a href="{{ route('register', ['package' => $package->id]) }}" class="btn {{ $loop->last ? 'btn-primary' : 'btn-outline-primary' }} w-100 fw-bold py-2">Pilih Paket</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
