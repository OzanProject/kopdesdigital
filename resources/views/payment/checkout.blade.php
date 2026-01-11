@extends('layouts.landing')

@section('title', 'Selesaikan Pembayaran')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg text-center p-5">
                <div class="mb-4 text-primary">
                    <i class="fas fa-file-invoice-dollar fa-4x"></i>
                </div>
                <h3 class="fw-bold mb-3">Selesaikan Pembayaran</h3>
                <p class="text-muted mb-4">Invoice #{{ $transaction->order_id }}</p>

                @if(session('success'))
                    <div class="alert alert-success text-start">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger text-start">
                        <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning text-start">
                        <i class="fas fa-clock"></i> {{ session('warning') }}
                    </div>
                @endif
                
                <div class="bg-light p-4 rounded-3 mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Paket Langganan</span>
                        <span class="fw-bold">{{ $transaction->package->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Harga</span>
                        <span class="fw-bold">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total Tagihan</span>
                        <span class="fw-bold fs-5 text-primary">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if(empty($transaction->snap_token))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> Sistem pembayaran belum dikonfigurasi. Silakan hubungi admin.
                    </div>
                    <!-- Renew Link Option -->
                    <form action="{{ route('payment.renew', $transaction->order_id) }}" method="POST">
                @else
                    <div id="payment-method-selector" class="mb-4">
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="payment_method" id="method-online" value="online" checked autocomplete="off">
                            <label class="btn btn-outline-primary" for="method-online">
                                <i class="fas fa-credit-card"></i> Online (Midtrans)
                            </label>
                          
                            <input type="radio" class="btn-check" name="payment_method" id="method-manual" value="manual" autocomplete="off">
                            <label class="btn btn-outline-primary" for="method-manual">
                                <i class="fas fa-university"></i> Transfer Manual
                            </label>
                        </div>
                    </div>

                    <!-- Online Payment (Midtrans) -->
                    <div id="payment-online">
                        <div id="snap-container"></div>
                        <button id="pay-button" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm py-3 mb-3">
                            <i class="fas fa-lock me-2"></i> Bayar Sekarang (Online)
                        </button>
                    </div>

                    <!-- Manual Payment -->
                    <div id="payment-manual" style="display: none;">
                        @if(!empty($settings['manual_transfer_info']))
                            <div class="alert alert-info text-start">
                                <h6><i class="fas fa-info-circle"></i> Instruksi Pembayaran:</h6>
                                {!! nl2br(e($settings['manual_transfer_info'])) !!}
                            </div>
                            
                            <form action="{{ route('payment.manual.store', $transaction->order_id) }}" method="POST" onsubmit="return confirm('Apakah Anda sudah melakukan transfer?');">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg w-100 fw-bold shadow-sm py-3 mb-3">
                                    <i class="fas fa-check-circle me-2"></i> Saya Sudah Transfer
                                </button>
                            </form>
                        @else
                            <div class="alert alert-warning">
                                Admin belum mengatur informasi rekening manual. Silakan pilih Online Payment.
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Renew Link Option (Always visible in case of expiry) -->
                <form action="{{ route('payment.renew', $transaction->order_id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-sm w-100 @if(!empty($transaction->snap_token)) mt-3 @endif">
                        <i class="fas fa-sync-alt me-1"></i> Link Kadaluarsa? Klik untuk Perbarui
                    </button>
                </form>

                <p class="text-muted text-center mt-3 small">
                    <i class="fas fa-shield-alt me-1"></i> Pembayaran aman & terenykripsi
                </p>
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
            if (methodManual.checked) {
                divOnline.style.display = 'none';
                divManual.style.display = 'block';
            } else {
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
<!-- Midtrans Snap JS -->
@php
    $isProduction = isset($settings['midtrans_is_production']) && $settings['midtrans_is_production'] === '1';
    $clientKey = $isProduction ? ($settings['midtrans_client_key_production'] ?? '') : ($settings['midtrans_client_key_sandbox'] ?? '');
    $snapUrl = $isProduction ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js';
@endphp
<script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $transaction->snap_token }}', {
            onSuccess: function(result){
                window.location.href = "{{ route('payment.success') }}";
            },
            onPending: function(result){
                alert("Menunggu pembayaran!");
            },
            onError: function(result){
                alert("Pembayaran gagal!");
            }
        });
    };
</script>
@endif
@endsection
