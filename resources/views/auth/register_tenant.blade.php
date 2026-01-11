@extends('layouts.landing')

@section('title', 'Pendaftaran Koperasi Baru')

@section('content')
<style>
    .auth-section {
        background: radial-gradient(circle at top left, #f8fafc 0%, #e2e8f0 100%);
        min-height: 100vh;
        padding-top: 120px;
        padding-bottom: 60px;
    }
    .register-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        background: white;
        overflow: hidden;
    }
    .register-sidebar {
        background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
        color: white;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #475569;
        margin-bottom: 8px;
    }
    .form-control, .form-select {
        padding: 12px 16px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        font-size: 0.95rem;
        transition: all 0.3s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }
    .input-group-text {
        background: transparent;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        color: #94a3b8;
    }
    .step-indicator {
        width: 32px;
        height: 32px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 12px;
    }
    .btn-register-submit {
        padding: 14px;
        border-radius: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.2);
    }
</style>

<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <div class="card register-card">
                    <div class="row g-0">
                        <div class="col-lg-4 register-sidebar d-none d-lg-flex">
                            <h2 class="fw-bold mb-4">Langkah Cerdas Untuk Koperasi.</h2>
                            <div class="d-flex align-items-center mb-4">
                                <div class="step-indicator">1</div>
                                <div><small class="d-block opacity-75">Langkah 01</small><strong>Detail Koperasi</strong></div>
                            </div>
                            <div class="d-flex align-items-center mb-4">
                                <div class="step-indicator">2</div>
                                <div><small class="d-block opacity-75">Langkah 02</small><strong>Pembuatan Akun Admin</strong></div>
                            </div>
                            <div class="mt-5 p-4 rounded-4" style="background: rgba(255,255,255,0.1);">
                                <p class="small mb-0 fst-italic">"Proses pendaftaran hanya memakan waktu 2 menit. Setelah ini Anda bisa langsung mengelola anggota."</p>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="card-body p-4 p-md-5">
                                <div class="mb-5">
                                    <h3 class="fw-bold text-dark">Daftar Akun Baru</h3>
                                    <p class="text-muted">Lengkapi data di bawah ini untuk memulai sistem Anda.</p>
                                </div>

                                @if($errors->any())
                                    <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
                                        <ul class="mb-0 small">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <h6 class="text-uppercase fw-bold text-primary small ls-2 mb-3">01. Informasi Koperasi</h6>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Paket Langganan</label>
                                            <div class="input-group">
                                                <span class="input-group-text border-end-0"><i class="fas fa-box"></i></span>
                                                <select name="package_id" class="form-select border-start-0 @error('package_id') is-invalid @enderror">
                                                    @foreach($packages as $package)
                                                        <option value="{{ $package->id }}" {{ (old('package_id') == $package->id || (isset($selectedPackage) && $selectedPackage->id == $package->id)) ? 'selected' : '' }}>
                                                            {{ $package->name }} (Rp {{ number_format($package->price, 0, ',', '.') }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Nama Koperasi</label>
                                            <div class="input-group">
                                                <span class="input-group-text border-end-0"><i class="fas fa-building"></i></span>
                                                <input type="text" name="koperasi_name" class="form-control border-start-0 @error('koperasi_name') is-invalid @enderror" value="{{ old('koperasi_name') }}" required placeholder="Koperasi Berkah Sentosa">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Alamat Lengkap Kantor</label>
                                            <textarea name="koperasi_address" class="form-control @error('koperasi_address') is-invalid @enderror" rows="2" required placeholder="Jl. Raya Desa No. 123...">{{ old('koperasi_address') }}</textarea>
                                        </div>

                                        <div class="col-12 mt-5">
                                            <h6 class="text-uppercase fw-bold text-primary small ls-2 mb-3">02. Akun Administrator</h6>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Nama Lengkap Anda</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Contoh: Ahmad Sulaiman">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Email Kerja</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="ahmad@koperasi.com">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Minimal 8 karakter">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Konfirmasi Password</label>
                                            <input type="password" name="password_confirmation" class="form-control" required placeholder="Ulangi password">
                                        </div>

                                        <div class="col-12 mt-5">
                                            <button type="submit" class="btn btn-primary w-100 btn-register-submit btn-lg">
                                                Buat Akun Koperasi Saya <i class="fas fa-chevron-right ms-2"></i>
                                            </button>
                                            <p class="text-center mt-4 mb-0 text-muted">
                                                Sudah bergabung? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Masuk di sini</a>
                                            </p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection