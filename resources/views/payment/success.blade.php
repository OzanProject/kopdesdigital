@extends('layouts.landing')

@section('title', session('manual_pending') ? 'Menunggu Konfirmasi' : 'Pembayaran Berhasil')

@section('content')
<style>
    .success-wrapper {
        padding: 160px 0 100px;
        background-color: #f8fafc;
        min-height: 100vh;
        display: flex;
        align-items: center;
    }
    .status-card {
        background: white;
        border-radius: 30px;
        border: none;
        box-shadow: 0 20px 40px rgba(0,0,0,0.03);
        padding: 60px 40px;
        position: relative;
        overflow: hidden;
    }
    .status-icon-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        position: relative;
        z-index: 1;
    }
    .bg-soft-success { background-color: rgba(34, 197, 94, 0.1); color: #22c55e; }
    .bg-soft-warning { background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    
    .celebration-element {
        position: absolute;
        pointer-events: none;
        z-index: 0;
    }
    
    .btn-action {
        padding: 16px 40px;
        border-radius: 14px;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    .btn-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
</style>

<div class="success-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center">
                <div class="status-card animate__animated animate__zoomIn">
                    
                    @if(session('manual_pending'))
                        <div class="status-icon-circle bg-soft-warning animate__animated animate__pulse animate__infinite">
                            <i class="fas fa-hourglass-half fa-3x"></i>
                        </div>
                        
                        <h2 class="fw-extrabold text-dark mb-3">Pembayaran Sedang Diverifikasi</h2>
                        <p class="text-muted fs-5 mb-5 mx-auto" style="max-width: 500px;">
                            Terima kasih! Bukti transfer Anda telah kami terima. Tim kami akan melakukan verifikasi dalam waktu maksimal 1x24 jam.
                        </p>
                        
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                            <a href="{{ route('dashboard') }}" class="btn btn-warning btn-action text-white">
                                <i class="fas fa-desktop me-2"></i> Ke Dashboard (Pending)
                            </a>
                            <a href="https://wa.me/{{ $settings['company_phone'] ?? '' }}" class="btn btn-outline-secondary btn-action">
                                <i class="fab fa-whatsapp me-2"></i> Hubungi Admin
                            </a>
                        </div>
                    @else
                        <div class="status-icon-circle bg-soft-success animate__animated animate__bounceIn">
                            <i class="fas fa-check fa-3x"></i>
                        </div>
                        
                        <h2 class="fw-extrabold text-dark mb-3">Pembayaran Berhasil!</h2>
                        <p class="text-muted fs-5 mb-5 mx-auto" style="max-width: 500px;">
                            Selamat! Akun koperasi Anda kini telah aktif sepenuhnya. Anda sekarang memiliki akses penuh ke seluruh fitur layanan kami.
                        </p>
                        
                        <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-action shadow-lg">
                                <i class="fas fa-rocket me-2"></i> Mulai Kelola Koperasi
                            </a>
                        </div>
                    @endif
                    
                    <div class="mt-5 pt-4 border-top opacity-50">
                        <p class="small mb-0 text-muted">Invoice telah dikirimkan ke email terdaftar Anda.</p>
                    </div>
                </div>
                
                <div class="mt-4 animate__animated animate__fadeIn" style="animation-delay: 1s;">
                    <a href="{{ route('home') }}" class="text-decoration-none text-muted small">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection