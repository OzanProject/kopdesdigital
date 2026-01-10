@extends('layouts.landing')

@section('title', 'Pendaftaran Koperasi Baru')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-lg rounded-lg overflow-hidden">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="fw-bold mb-0">Pendaftaran Koperasi Baru</h3>
                    <p class="mb-0 text-white-50">Mulai kelola koperasi Anda secara digital dalam hitungan menit.</p>
                </div>
                <div class="card-body p-5">
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="row">
                            <!-- Kolom Kiri: Data Koperasi -->
                            <div class="col-md-6 border-end">
                                <h5 class="fw-bold text-primary mb-3"><i class="fas fa-building me-2"></i> Data Koperasi</h5>
                                
                                <div class="mb-3">
                                    <label class="form-label">Paket Langganan</label>
                                    <select name="package_id" class="form-select @error('package_id') is-invalid @enderror">
                                        @foreach($packages as $package)
                                            <option value="{{ $package->id }}" {{ (old('package_id') == $package->id || (isset($selectedPackage) && $selectedPackage->id == $package->id)) ? 'selected' : '' }}>
                                                {{ $package->name }} - Rp {{ number_format($package->price, 0, ',', '.') }}/bulan
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('package_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Koperasi</label>
                                    <input type="text" name="koperasi_name" class="form-control @error('koperasi_name') is-invalid @enderror" value="{{ old('koperasi_name') }}" required placeholder="Contoh: Koperasi Maju Jaya">
                                    @error('koperasi_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea name="koperasi_address" class="form-control @error('koperasi_address') is-invalid @enderror" rows="3" required placeholder="Alamat kantor koperasi...">{{ old('koperasi_address') }}</textarea>
                                    @error('koperasi_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nomor Telepon</label>
                                    <input type="text" name="koperasi_phone" class="form-control @error('koperasi_phone') is-invalid @enderror" value="{{ old('koperasi_phone') }}" placeholder="0812...">
                                    @error('koperasi_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kolom Kanan: Data Admin -->
                            <div class="col-md-6 ps-md-4">
                                <h5 class="fw-bold text-primary mb-3"><i class="fas fa-user-shield me-2"></i> Akun Admin</h5>

                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap Admin</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Budi Santoso">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="budi@example.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>

                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg fw-bold">Daftar Sekarang</button>
                                </div>
                                <div class="text-center mt-3">
                                    <span class="text-muted">Sudah punya akun?</span> <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Masuk di sini</a>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
