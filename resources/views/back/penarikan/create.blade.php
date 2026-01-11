@extends('layouts.admin')

@section('title', 'Form Penarikan Simpanan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-header bg-warning py-3">
                <h6 class="mb-0 font-weight-bold text-dark">
                    <i class="fas fa-wallet mr-2"></i> Ambil Simpanan Sukarela
                </h6>
            </div>
            
            <form action="{{ route('penarikan.store') }}" method="POST">
                @csrf
                <div class="card-body p-4">
                    <div class="alert bg-light border-left border-warning rounded-lg mb-4 d-flex align-items-center">
                        <i class="fas fa-info-circle text-warning mr-3 fa-2x"></i>
                        <div class="small">
                            <strong class="d-block text-dark">Informasi Penarikan:</strong>
                            Hanya <b>Simpanan Sukarela</b> yang dapat ditarik sewaktu-waktu. Pastikan saldo nasabah mencukupi sebelum memproses transaksi ini.
                        </div>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label class="small font-weight-bold">Pilih Nasabah / Anggota</label>
                        <select name="nasabah_id" class="form-control select2 @error('nasabah_id') is-invalid @enderror" style="width: 100%;" required>
                            <option value="">-- Cari Nama atau No. Anggota --</option>
                            @foreach($nasabahs as $nasabah)
                                <option value="{{ $nasabah->id }}" {{ old('nasabah_id') == $nasabah->id ? 'selected' : '' }}>
                                    {{ $nasabah->no_anggota }} - {{ $nasabah->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('nasabah_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        <small class="form-text text-muted">Sistem akan memvalidasi sisa saldo sukarela secara otomatis saat tombol simpan diklik.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="small font-weight-bold text-danger">Jumlah Penarikan (Rp)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-danger text-white border-0 fw-bold">Rp</span>
                                    </div>
                                    <input type="number" name="jumlah" class="form-control form-control-lg font-weight-bold @error('jumlah') is-invalid @enderror" 
                                           placeholder="0" value="{{ old('jumlah') }}" required>
                                </div>
                                @error('jumlah') <span class="invalid-feedback text-sm d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="small font-weight-bold">Tanggal Penarikan</label>
                                <input type="date" name="tanggal_penarikan" class="form-control form-control-lg @error('tanggal_penarikan') is-invalid @enderror" 
                                       value="{{ old('tanggal_penarikan', date('Y-m-d')) }}" required>
                                @error('tanggal_penarikan') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="small font-weight-bold">Keterangan Penarikan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Kebutuhan mendesak anggota / tarik tunai di kantor...">{{ old('keterangan') }}</textarea>
                    </div>
                </div>

                <div class="card-footer bg-white py-4 d-flex justify-content-between px-4">
                    <a href="{{ route('penarikan.index') }}" class="btn btn-light px-4 font-weight-bold">Kembali</a>
                    <button type="submit" class="btn btn-warning px-5 font-weight-bold rounded-pill shadow" onclick="return confirm('Konfirmasi penarikan saldo? Pastikan uang tunai sudah diserahkan ke nasabah.')">
                        <i class="fas fa-check-circle mr-2"></i> Proses Penarikan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection