@extends('layouts.landing')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="text-center">
        <div class="mb-4 text-success">
            <i class="fas fa-check-circle fa-5x"></i>
        </div>
        <h2 class="fw-bold mb-3">Pembayaran Berhasil!</h2>
        <p class="lead mb-4">Akun koperasi Anda telah aktif. Silakan masuk ke dashboard untuk mulai mengelola koperasi Anda.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-5 shadow">Masuk ke Dashboard</a>
    </div>
</div>
@endsection
