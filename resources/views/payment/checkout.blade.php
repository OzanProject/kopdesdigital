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
                    <div id="snap-container"></div>
                    
                    <button id="pay-button" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm py-3 mb-3">
                        <i class="fas fa-lock me-2"></i> Bayar Sekarang
                    </button>
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
