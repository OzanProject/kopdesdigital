@extends('layouts.admin')

@section('title', isset($simpanan) ? 'Edit Transaksi Simpanan' : 'Input Setoran Simpanan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 font-weight-bold text-primary">
                    <i class="fas fa-hand-holding-usd mr-2"></i>
                    {{ isset($simpanan) ? 'Update Transaksi Simpanan' : 'Form Setoran Baru' }}
                </h6>
            </div>
            
            <form action="{{ isset($simpanan) ? route('simpanan.update', $simpanan->id) : route('simpanan.store') }}" method="POST">
                @csrf
                @if(isset($simpanan)) @method('PUT') @endif
                
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label class="small font-weight-bold">Pilih Anggota Koperasi</label>
                        <select name="nasabah_id" class="form-control select2 @error('nasabah_id') is-invalid @enderror" style="width: 100%;" required>
                            <option value="">-- Cari No. Anggota atau Nama --</option>
                            @foreach($nasabahs as $nasabah)
                                <option value="{{ $nasabah->id }}" 
                                    {{ (old('nasabah_id', $simpanan->nasabah_id ?? '') == $nasabah->id) ? 'selected' : '' }}>
                                    {{ $nasabah->no_anggota }} - {{ $nasabah->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('nasabah_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small font-weight-bold">Jenis Simpanan</label>
                                <select name="jenis" class="form-control @error('jenis') is-invalid @enderror" required>
                                    <option value="pokok" {{ old('jenis', $simpanan->jenis ?? '') == 'pokok' ? 'selected' : '' }}>Simpanan Pokok</option>
                                    <option value="wajib" {{ old('jenis', $simpanan->jenis ?? '') == 'wajib' ? 'selected' : '' }}>Simpanan Wajib</option>
                                    <option value="sukarela" {{ old('jenis', $simpanan->jenis ?? 'sukarela') == 'sukarela' ? 'selected' : '' }}>Simpanan Sukarela</option>
                                </select>
                                @error('jenis') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small font-weight-bold">Jumlah Setoran (Rp)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light border-right-0 fw-bold">Rp</span>
                                    </div>
                                    <input type="number" name="jumlah" class="form-control border-left-0 font-weight-bold @error('jumlah') is-invalid @enderror" 
                                           placeholder="0" min="1000" value="{{ old('jumlah', $simpanan->jumlah ?? '') }}" required>
                                </div>
                                @error('jumlah') <span class="invalid-feedback text-sm d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="small font-weight-bold">Tanggal Transaksi</label>
                        <input type="date" name="tanggal_transaksi" class="form-control @error('tanggal_transaksi') is-invalid @enderror" 
                               value="{{ old('tanggal_transaksi', isset($simpanan) ? $simpanan->tanggal_transaksi->format('Y-m-d') : date('Y-m-d')) }}" required>
                        @error('tanggal_transaksi') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label class="small font-weight-bold">Keterangan Tambahan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Pembayaran melalui transfer bank atau setoran tunai...">{{ old('keterangan', $simpanan->keterangan ?? '') }}</textarea>
                    </div>
                </div>

                <div class="card-footer bg-white py-4 d-flex justify-content-between">
                    <a href="{{ route('simpanan.index') }}" class="btn btn-light px-4 font-weight-bold">Kembali</a>
                    <button type="submit" class="btn btn-primary px-5 font-weight-bold rounded-pill shadow">
                        <i class="fas fa-save mr-2"></i> {{ isset($simpanan) ? 'Simpan Perubahan' : 'Proses Setoran' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection