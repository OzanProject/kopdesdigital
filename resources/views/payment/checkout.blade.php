@extends('layouts.landing')

@section('title', 'Selesaikan Pembayaran')

@section('content')
<style>
    .payment-wrapper { padding-top: 140px; background-color: #f8fafc; min-height: 100vh; }
    .payment-card { border-radius: 24px; border: none; overflow: hidden; }
    .invoice-header { background: #0f172a; color: white; padding: 30px; }
    .billing-item { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.95rem; }
    .total-billing { background: #f1f5f9; border-radius: 16px; padding: 20px; border: 1px dashed #cbd5e1; }
    .btn-payment { padding: 16px; border-radius: 14px; font-weight: 700; transition: all 0.3s; }
    .method-card { cursor: pointer; border: 2px solid #e2e8f0; border-radius: 16px; transition: all 0.2s; position: relative; }
    .btn-check:checked + .method-card { border-color: #0d6efd; background-color: rgba(13, 110, 253, 0.04); }
    .btn-check:checked + .method-card .fa-circle-check { display: block !important; }
</style>

<div class="payment-wrapper pb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card payment-card shadow-lg">
                    <div class="invoice-header text-center">
                        <div class="mb-2 opacity-50"><i class="fas fa-file-invoice-dollar fa-2x"></i></div>
                        <h4 class="fw-bold mb-1">Rincian Pembayaran</h4>
                        <p class="small mb-0 opacity-75">Order ID: #{{ $transaction->order_id }}</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        @if(session('success'))
                            <div class="alert alert-success border-0 rounded-4 d-flex align-items-center mb-4">
                                <i class="fas fa-check-circle me-2 fs-4"></i> {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error') || session('warning'))
                            <div class="alert @if(session('error')) alert-danger @else alert-warning @endif border-0 rounded-4 d-flex align-items-center mb-4">
                                <i class="fas fa-exclamation-circle me-2 fs-4"></i> {{ session('error') ?? session('warning') }}
                            </div>
                        @endif

                        <div class="mb-5">
                            <div class="billing-item">
                                <span class="text-muted">Item</span>
                                <span class="fw-bold">Paket {{ $transaction->package->name }}</span>
                            </div>
                            <div class="billing-item">
                                <span class="text-muted">Metode</span>
                                <span class="badge bg-light text-dark border">{{ $transaction->payment_type ?? 'Belum Dipilih' }}</span>
                            </div>
                            <div class="total-billing mt-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark">Total Tagihan</span>
                                    <h3 class="fw-bold text-primary mb-0">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>

                        @if(isset($transaction->payment_type) && str_contains($transaction->payment_type, 'manual') && $transaction->status == 'pending')
                            <div class="text-center p-4 border rounded-4 bg-light">
                                <div class="spinner-grow text-warning mb-3" role="status"></div>
                                <h5 class="fw-bold">Menunggu Verifikasi</h5>
                                <p class="small text-muted mb-4">Bukti transfer Anda sedang dicek oleh tim kami secara manual.</p>
                                <hr>
                                <p class="small mb-0">Butuh bantuan? <a href="https://wa.me/{{ $settings['company_phone'] ?? '' }}" class="text-decoration-none fw-bold">Hubungi WhatsApp</a></p>
                            </div>

                        @elseif(empty($transaction->snap_token) && !str_contains($transaction->payment_type, 'manual'))
                            <div class="alert alert-danger border-0 rounded-4 p-4 text-center">
                                <i class="fas fa-plug fa-2x mb-3 opacity-25"></i>
                                <h6 class="fw-bold">Metode Pembayaran Tidak Tersedia</h6>
                                <p class="small mb-0">Silakan hubungi administrator untuk konfigurasi Midtrans.</p>
                            </div>
                        @else
                            <div class="mb-4">
                                <label class="fw-bold small text-muted text-uppercase ls-1 mb-3">Pilih Metode Pembayaran</label>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="payment_method" id="method-online" value="online" checked autocomplete="off">
                                        <label class="btn p-3 w-100 method-card text-start h-100 d-flex flex-column" for="method-online">
                                            <i class="fas fa-circle-check text-primary position-absolute top-0 end-0 m-2" style="display:none"></i>
                                            <i class="fas fa-credit-card mb-2 fs-5 text-primary"></i>
                                            <span class="fw-bold small d-block">Online</span>
                                            <span class="text-muted" style="font-size: 0.7rem;">VA, E-Wallet, Card</span>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="payment_method" id="method-manual" value="manual" autocomplete="off">
                                        <label class="btn p-3 w-100 method-card text-start h-100 d-flex flex-column" for="method-manual">
                                            <i class="fas fa-circle-check text-primary position-absolute top-0 end-0 m-2" style="display:none"></i>
                                            <i class="fas fa-university mb-2 fs-5 text-primary"></i>
                                            <span class="fw-bold small d-block">Transfer</span>
                                            <span class="text-muted" style="font-size: 0.7rem;">Manual Verifikasi</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div id="payment-online">
                                <button id="pay-button" class="btn btn-primary btn-payment w-100 shadow-sm mb-3">
                                    <i class="fas fa-lock me-2"></i> Bayar Sekarang (Online)
                                </button>
                            </div>

                            <div id="payment-manual" style="display: none;">
                                @if(!empty($settings['manual_transfer_info']))
                                    <div class="bg-light p-3 rounded-4 mb-4 small border">
                                        <div class="fw-bold mb-2"><i class="fas fa-info-circle me-1"></i> Rekening Tujuan:</div>
                                        {!! nl2br(e($settings['manual_transfer_info'])) !!}
                                    </div>
                                    <form action="{{ route('payment.manual.store', $transaction->order_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-payment w-100 shadow-sm mb-3">
                                            <i class="fas fa-check-circle me-2"></i> Konfirmasi Sudah Transfer
                                        </button>
                                    </form>
                                @else
                                    <div class="alert alert-warning small rounded-4">Info rekening belum diatur oleh admin.</div>
                                @endif
                            </div>
                        @endif

                        <div class="mt-4 pt-4 border-top">
                            <form action="{{ route('payment.renew', $transaction->order_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link btn-sm w-100 text-decoration-none text-muted">
                                    <i class="fas fa-sync-alt me-1"></i> Masalah pembayaran? <strong>Perbarui Invoice</strong>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <p class="text-muted small"><i class="fas fa-shield-halved text-success me-1"></i> Pembayaran Terenkripsi & Aman</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const methodOnline = document.getElementById('method-online');
        const methodManual = document.getElementById('method-manual');
        const divOnline = document.getElementById('payment-online');
        const divManual = document.getElementById('payment-manual');

        function togglePayment() {
            if (methodManual && methodManual.checked) {
                divOnline.style.display = 'none';
                divManual.style.display = 'block';
            } else if (divOnline) {
                divOnline.style.display = 'block';
                divManual.style.display = 'none';
            }
        }

        if (methodOnline && methodManual) {
            methodOnline.addEventListener('change', togglePayment);
            methodManual.addEventListener('change', togglePayment);
        }
    });
</script>

@if(!empty($transaction->snap_token))
    @php
        $isProduction = isset($settings['midtrans_is_production']) && $settings['midtrans_is_production'] === '1';
        $clientKey = $isProduction ? ($settings['midtrans_client_key_production'] ?? '') : ($settings['midtrans_client_key_sandbox'] ?? '');
        $snapUrl = $isProduction ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js';
    @endphp
    <script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
    <script type="text/javascript">
        const payBtn = document.getElementById('pay-button');
        if(payBtn) {
            payBtn.onclick = function(){
                snap.pay('{{ $transaction->snap_token }}', {
                    onSuccess: function(result){ window.location.href = "{{ route('payment.success') }}"; },
                    onPending: function(result){ alert("Menunggu pembayaran!"); },
                    onError: function(result){ alert("Pembayaran gagal!"); }
                });
            };
        }
    </script>
@endif
@endsection