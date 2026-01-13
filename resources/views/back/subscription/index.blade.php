@extends('layouts.admin')

@section('title', 'Manajemen Paket & Langganan')

@section('content')
<style>
    /* Styling Pricing Cards */
    .pricing-card {
        border: none;
        border-radius: 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .pricing-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .pricing-card.active-plan {
        border: 2px solid #28a745;
    }
    .package-name {
        font-weight: 800;
        letter-spacing: 1px;
        color: #64748b;
    }
    .price-tag {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1e293b;
    }
    .feature-list {
        padding: 0;
        list-style: none;
    }
    .feature-list li {
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.9rem;
        color: #475569;
    }
    .feature-list li:last-child { border-bottom: none; }
    
    /* Promo Box */
    .promo-badge-card {
        background: linear-gradient(45deg, #ffffff, #f0fdf4);
        border: 1px dashed #22c55e;
        border-radius: 12px;
    }
    .copy-code {
        background: #f1f5f9;
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        transition: 0.2s;
    }
    .copy-code:hover { background: #e2e8f0; }

    /* Subscription Status Banner */
    .sub-status-card {
        background: #1e293b;
        color: white;
        border-radius: 16px;
        border: none;
    }
</style>

<div class="row mb-4">
    <div class="col-12">
        <div class="card sub-status-card shadow-sm">
            <div class="card-body p-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="bg-primary p-3 rounded-circle mr-3 shadow-sm">
                        <i class="fas fa-crown fa-2x text-white"></i>
                    </div>
                    <div>
                        <h5 class="font-weight-bold mb-1">Paket Aktif: <span class="text-primary">{{ $currentPackage->name ?? 'Free Tier' }}</span></h5>
                        <p class="mb-0 small opacity-75">
                            Status: 
                            @if($koperasi->status == 'active')
                                <span class="badge badge-success px-3 rounded-pill">AKTIF</span>
                            @elseif($koperasi->status == 'pending_payment')
                                <span class="badge badge-warning px-3 rounded-pill text-dark">MENUNGGU PEMBAYARAN</span>
                            @else
                                <span class="badge badge-danger px-3 rounded-pill">{{ strtoupper($koperasi->status) }}</span>
                            @endif
                            <span class="mx-2">|</span>
                            Masa Berlaku: <b>{{ $koperasi->subscription_end_date ? $koperasi->subscription_end_date->translatedFormat('d M Y') : 'Selamanya' }}</b>
                            @if($koperasi->subscription_end_date && $koperasi->subscription_end_date->isFuture())
                                <span class="text-warning ml-1">({{ $koperasi->subscription_end_date->diffInDays(now()) }} Hari Lagi)</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="mt-3 mt-md-0">
                    <a href="#upgrade-section" class="btn btn-primary btn-lg rounded-pill font-weight-bold shadow-sm scroll-to">
                        <i class="fas fa-rocket mr-2"></i> Upgrade Layanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@if($availableDiscounts->count() > 0)
<div class="card border-0 shadow-sm mb-4 promo-badge-card animate__animated animate__headShake">
    <div class="card-body p-3">
        <h6 class="font-weight-bold text-success mb-3"><i class="fas fa-bolt mr-2"></i> Penawaran Terbatas Untuk Anda:</h6>
        <div class="row">
            @foreach($availableDiscounts as $promo)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                <div class="d-flex align-items-center p-2 bg-white rounded border shadow-xs">
                    <div class="text-success mr-3 ml-2"><i class="fas fa-ticket-alt fa-lg"></i></div>
                    <div>
                        <div class="small text-muted mb-0">Klik Kode Promo:</div>
                        <strong class="text-primary copy-code" style="cursor:pointer" title="Klik untuk pakai">{{ $promo->code }}</strong>
                        <div class="small font-weight-bold text-success">
                            @if($promo->type == 'percent') Diskon {{ $promo->amount }}% @else Hemat Rp{{ number_format($promo->amount/1000, 0) }}rb @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<div class="text-center mb-4 mt-5" id="upgrade-section">
    <h3 class="font-weight-bold">Pilih Paket Masa Depan Koperasi</h3>
    <p class="text-muted">Investasi cerdas untuk digitalisasi operasional yang lebih transparan.</p>
</div>

<div class="row g-4 mb-5">
    @foreach($packages as $package)
    <div class="col-md-4 mb-4">
        <div class="card h-100 pricing-card shadow-sm {{ $currentPackage->id == $package->id ? 'active-plan shadow' : '' }}">
            @if($currentPackage->id == $package->id)
                <div class="bg-success text-white text-center py-1 font-weight-bold small">PAKET ANDA SAAT INI</div>
            @endif
            
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h6 class="package-name text-uppercase">{{ $package->name }}</h6>
                    <div class="price-tag">
                        <span style="font-size: 1.2rem; vertical-align: top; margin-top: 10px; display: inline-block;">Rp</span>{{ number_format($package->price, 0, ',', '.') }}
                    </div>
                    <p class="text-muted small">
                        @if($package->duration_days >= 360) / Tahun @elseif($package->duration_days >= 30) / Bulan @else / {{ $package->duration_days }} Hari @endif
                    </p>
                </div>

                <ul class="feature-list mb-4">
                    <li><i class="fas fa-check-circle text-success mr-2"></i> <strong>{{ $package->max_members > 0 ? number_format($package->max_members) : 'Unlimited' }}</strong> Kapasitas Anggota</li>
                    <li><i class="fas fa-check-circle text-success mr-2"></i> <strong>{{ $package->max_users > 0 ? $package->max_users : 'Unlimited' }}</strong> User Administrator</li>
                    <li><i class="fas fa-check-circle text-success mr-2"></i> {{ $package->description ?? 'Fitur Lengkap & Support' }}</li>
                    <li><i class="fas fa-shield-alt text-primary mr-2"></i> Cloud Auto Backup & Security</li>
                </ul>

                <form action="{{ route('subscription.upgrade') }}" method="POST" class="subscription-form mt-auto">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                    
                    <div class="form-group mb-3">
                        <div class="input-group input-group-sm shadow-xs">
                            <input type="text" name="discount_code" class="form-control border-right-0" placeholder="Kode Promo">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-info btn-check-coupon px-3">Cek</button>
                            </div>
                        </div>
                        <div class="coupon-msg mt-1 small" style="min-height: 15px;"></div>
                    </div>

                    @if($currentPackage->id != $package->id)
                        <button type="submit" class="btn btn-primary btn-block btn-lg rounded-pill font-weight-bold shadow-sm">
                            Pilih Paket Ini
                        </button>
                    @else
                        <button type="submit" class="btn btn-outline-success btn-block btn-lg rounded-pill font-weight-bold">
                            <i class="fas fa-sync-alt mr-1"></i> Perpanjang Paket
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-history mr-2 text-muted"></i> Histori Transaksi Langganan</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover m-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4">Invoice</th>
                                <th class="border-0">Paket Layanan</th>
                                <th class="border-0">Nominal Tagihan</th>
                                <th class="border-0 text-center">Metode Bayar</th>
                                <th class="border-0 text-center">Status</th>
                                <th class="border-0 text-right px-4">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                            <tr>
                                <td class="align-middle px-4">
                                    <span class="font-weight-bold text-primary">#{{ $trx->order_id }}</span><br>
                                    <small class="text-muted">{{ $trx->created_at->translatedFormat('d M Y, H:i') }}</small>
                                </td>
                                <td class="align-middle font-weight-bold">{{ $trx->package->name ?? 'Custom Plan' }}</td>
                                <td class="align-middle font-weight-bold">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                <td class="align-middle text-center small text-uppercase font-weight-bold text-muted">
                                    {{ $trx->payment_type ? str_replace('_', ' ', $trx->payment_type) : 'N/A' }}
                                </td>
                                <td class="align-middle text-center">
                                    @php
                                        $badge = match($trx->status) {
                                            'paid' => 'badge-success',
                                            'pending' => 'badge-warning',
                                            'failed', 'cancelled' => 'badge-danger',
                                            default => 'badge-secondary'
                                        };
                                        $label = match($trx->status) {
                                            'paid' => 'LUNAS',
                                            'pending' => 'MENUNGGU',
                                            'failed' => 'GAGAL',
                                            'cancelled' => 'DIBATALKAN',
                                            default => strtoupper($trx->status)
                                        };
                                    @endphp
                                    <span class="badge {{ $badge }} px-3 py-2 rounded-pill shadow-xs">{{ $label }}</span>
                                </td>
                                <td class="align-middle text-right px-4">
                                    @if($trx->status == 'pending')
                                        <div class="btn-group">
                                            <a href="{{ route('payment.show', $trx->order_id) }}" class="btn btn-sm btn-primary px-3 shadow-sm">Bayar</a>
                                            <form action="{{ route('subscription.transaction.destroy', $trx->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Batalkan pengajuan ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-white text-danger border ml-1"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    @else
                                        <button class="btn btn-sm btn-light border disabled px-3">Selesai</button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-5 text-muted opacity-50">Belum ada riwayat transaksi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Copy Code Functionality
        $('.copy-code').click(function() {
            var code = $(this).text();
            navigator.clipboard.writeText(code).then(function() {
                toastr.success('Kode promo ' + code + ' disalin!');
            });
            // Also fill inputs
            $('input[name="discount_code"]').val(code);
            $('html, body').animate({
                scrollTop: $("#upgrade-section").offset().top
            }, 500);
        });

        // Scroll to
        $('.scroll-to').click(function(e){
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $($(this).attr('href')).offset().top
            }, 500);
        });

        // Check Coupon AJAX
        $('.btn-check-coupon').click(function() {
            var btn = $(this);
            var form = btn.closest('form');
            var codeInput = form.find('input[name="discount_code"]');
            var packageId = form.find('input[name="package_id"]').val();
            var msgContainer = form.find('.coupon-msg');
            var code = codeInput.val();

            if (!code) {
                msgContainer.html('<span class="text-danger small">Masukkan kode dulu.</span>');
                return;
            }

            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

            $.ajax({
                url: "{{ route('subscription.check-coupon') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    code: code,
                    package_id: packageId
                },
                success: function(response) {
                    btn.prop('disabled', false).text('Cek');
                    if(response.valid) {
                        msgContainer.html('<span class="text-success small"><i class="fas fa-check-circle"></i> ' + response.message + '</span>');
                        codeInput.addClass('is-valid').removeClass('is-invalid');
                    } else {
                        msgContainer.html('<span class="text-danger small"><i class="fas fa-times-circle"></i> ' + response.message + '</span>');
                        codeInput.addClass('is-invalid').removeClass('is-valid');
                    }
                },
                error: function(xhr) {
                    btn.prop('disabled', false).text('Cek');
                    msgContainer.html('<span class="text-danger small">Terjadi kesalahan sistem.</span>');
                }
            });
        });
    });
</script>
@endpush