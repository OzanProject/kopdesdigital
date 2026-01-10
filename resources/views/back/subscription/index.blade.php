@extends('layouts.admin')

@section('title', 'Kelola Langganan & Paket')

@section('content')

<!-- Current Subscription Status -->
<div class="row">
    <div class="col-12">
        <div class="card bg-light shadow-sm border-left-primary">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div>
                    <h5 class="font-weight-bold text-primary mb-1">Paket Saat Ini: {{ $currentPackage->name ?? 'Free Tier' }}</h5>
                    <div class="text-muted">
                        Status: 
                        @if($koperasi->status == 'active')
                            <span class="badge badge-success px-2">Aktif</span>
                        @elseif($koperasi->status == 'pending_payment')
                            <span class="badge badge-warning px-2">Menunggu Pembayaran</span>
                        @else
                            <span class="badge badge-danger px-2">{{ ucfirst($koperasi->status) }}</span>
                        @endif
                        <span class="mx-2">|</span>
                        Berakhir pada: <strong>{{ $koperasi->subscription_end_date ? $koperasi->subscription_end_date->translatedFormat('d F Y') : '-' }}</strong>
                        @if($koperasi->subscription_end_date && $koperasi->subscription_end_date->isFuture())
                            <small class="text-danger ml-1">({{ $koperasi->subscription_end_date->diffInDays(now()) }} hari lagi)</small>
                        @endif
                    </div>
                </div>
                <div class="mt-3 mt-md-0">
                    <a href="#upgrade-section" class="btn btn-primary btn-sm scroll-to"><i class="fas fa-arrow-circle-up mr-1"></i> Upgrade Paket</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Promo Banner -->
@if($availableDiscounts->count() > 0)
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas fa-tag"></i> Promo Spesial Tersedia!</h5>
    <div class="row mt-2">
        @foreach($availableDiscounts as $promo)
        <div class="col-md-3 col-sm-6 mb-2">
            <div class="info-box shadow-none bg-light border mb-0" style="min-height: 80px;">
                <span class="info-box-icon"><i class="fas fa-percentage text-success"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Kode: <strong class="text-primary copy-code" style="cursor:pointer" title="Klik untuk salin">{{ $promo->code }}</strong></span>
                    <span class="info-box-number" style="font-size: 14px;">
                        @if($promo->type == 'percent') Diskon {{ $promo->amount }}% @else Potongan Rp {{ number_format($promo->amount/1000, 0) }}rb @endif
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Pricing Packages -->
<h4 class="mb-3 mt-4 font-weight-bold text-dark" id="upgrade-section">Pilihan Paket Langganan</h4>
<div class="row d-flex align-items-stretch">
    @foreach($packages as $package)
    <div class="col-md-4 d-flex align-items-stretch">
        <div class="card w-100 card-outline {{ $currentPackage->id == $package->id ? 'card-success border-success' : 'card-primary' }} mb-4 shadow-sm transition-hover">
            @if($currentPackage->id == $package->id)
                <div class="ribbon-wrapper ribbon-lg">
                    <div class="ribbon bg-success">PAKET ANDA</div>
                </div>
            @endif
            <div class="card-header text-center bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="text-uppercase text-muted letter-spacing-1 mb-0">{{ $package->name }}</h5>
            </div>
            <div class="card-body text-center pt-2">
                <h1 class="display-4 font-weight-bold pricing-card-title">
                    <small style="font-size: 20px">Rp</small>{{ number_format($package->price, 0, ',', '.') }}
                    <small class="text-muted" style="font-size: 16px">
                        @if($package->duration_days >= 360)
                            / tahun
                        @elseif($package->duration_days >= 30)
                            / bulan
                        @else
                            / {{ $package->duration_days }} hari
                        @endif
                    </small>
                </h1>
                <ul class="list-unstyled mt-3 mb-4 text-left mx-4">
                    <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> {{ $package->max_members > 0 ? number_format($package->max_members) . ' Anggota' : 'Unlimited Anggota' }}</li>
                    <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> {{ $package->max_users > 0 ? $package->max_users . ' Admin User' : 'Unlimited Admin' }}</li>
                    <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> {{ $package->description ?? 'Full Support' }}</li>
                    <li><i class="fas fa-hdd text-secondary mr-2"></i> Auto Backup Data</li>
                </ul>
                
                <hr>

                <!-- Upgrade/Renew Form -->
                <form action="{{ route('subscription.upgrade') }}" method="POST" class="subscription-form">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                    
                    @if($currentPackage->id != $package->id)
                        <div class="form-group px-3">
                            <div class="input-group input-group-sm">
                                <input type="text" name="discount_code" class="form-control" placeholder="Kode Promo (Opsional)">
                                <span class="input-group-append">
                                <button type="button" class="btn btn-info btn-flat btn-check-coupon">Cek</button>
                                </span>
                            </div>
                            <small class="coupon-msg d-block text-left mt-1"></small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-sm">
                            <i class="fas fa-shopping-cart mr-2"></i> Pilih Paket Ini
                        </button>
                    @else
                        <!-- Form for renewal explicitly if needed, or just status -->
                         <div class="form-group px-3">
                            <div class="input-group input-group-sm">
                                <input type="text" name="discount_code" class="form-control" placeholder="Kode Promo (Perpanjang)">
                                <span class="input-group-append">
                                <button type="button" class="btn btn-info btn-flat btn-check-coupon">Cek</button>
                                </span>
                            </div>
                            <small class="coupon-msg d-block text-left mt-1"></small>
                        </div>
                        <button type="submit" class="btn btn-outline-success btn-block btn-lg">
                            <i class="fas fa-sync-alt mr-2"></i> Perpanjang Paket
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Transaction History -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history mr-2"></i> Riwayat Transaksi Terakhir</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>No. Invoice</th>
                                <th>Paket</th>
                                <th>Jumlah</th>
                                <th>Metode Bayar</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                            <tr>
                                <td><code>#{{ $trx->order_id }}</code></td>
                                <td>{{ $trx->package->name ?? '-' }}</td>
                                <td>Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                <td>
                                    {{ $trx->payment_type ? strtoupper(str_replace('_', ' ', $trx->payment_type)) : '-' }}
                                </td>
                                <td>
                                    @if($trx->status == 'paid')
                                        <span class="badge badge-success">Lunas</span>
                                    @elseif($trx->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($trx->status == 'failed' || $trx->status == 'cancelled')
                                        <span class="badge badge-danger">Gagal/Batal</span>
                                    @else
                                        <span class="badge badge-secondary">{{ $trx->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $trx->created_at->translatedFormat('d M Y H:i') }}</td>
                                <td>
                                    @if($trx->status == 'pending')
                                        <a href="{{ route('payment.show', $trx->order_id) }}" class="btn btn-xs btn-primary">Bayar</a>
                                        <form action="{{ route('subscription.transaction.destroy', $trx->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan/menghapus transaksi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @else
                                        <button class="btn btn-xs btn-secondary" disabled>Selesai</button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada riwayat transaksi.</td>
                            </tr>
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
    // Copy Code Logic
    $('.copy-code').click(function() {
        var code = $(this).text();
        // Insert to all inputs
        $('input[name="discount_code"]').val(code);
        
        // Visual Feedback
        var originalText = $(this).text();
        $(this).text("Copied!");
        setTimeout(() => {
            $(this).text(originalText);
        }, 1000);
        
        toastr.success('Kode promo ' + code + ' disalin ke formulir!');
    });

    // Check Coupon Logic (AJAX)
    $('.btn-check-coupon').click(function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var code = form.find('input[name="discount_code"]').val();
        var packageId = form.find('input[name="package_id"]').val();
        var msgContainer = form.find('.coupon-msg');

        if(!code) {
            toastr.error('Masukkan kode promo terlebih dahulu.');
            return;
        }

        $.ajax({
            url: "{{ route('subscription.check-coupon') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                code: code,
                package_id: packageId
            },
            beforeSend: function() {
                $(this).prop('disabled', true).text('Checking...');
            },
            success: function(response) {
                if(response.valid) {
                    msgContainer.html('<span class="text-success"><i class="fas fa-check-circle"></i> ' + response.message + '</span>');
                    toastr.success(response.message);
                } else {
                    msgContainer.html('<span class="text-danger"><i class="fas fa-times-circle"></i> ' + response.message + '</span>');
                }
            },
            error: function(xhr) {
                msgContainer.html('<span class="text-danger">Gagal mengecek kupon.</span>');
            },
            complete: function() {
                $('.btn-check-coupon').prop('disabled', false).text('Cek');
            }
        });
    });

    // Smooth Scroll
    $(".scroll-to").on('click', function(event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 80
            }, 800);
        }
    });

    // Form Confirmation
    $('.subscription-form').submit(function(e) {
        if(!confirm('Apakah Anda yakin ingin memilih paket ini/melakukan perpanjangan?')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
