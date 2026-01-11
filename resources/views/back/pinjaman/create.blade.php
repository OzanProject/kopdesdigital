@extends('layouts.admin')

@section('title', 'Pengajuan Pinjaman Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 font-weight-bold text-primary">
                    <i class="fas fa-file-invoice mr-2"></i> Formulir Pengajuan Pinjaman
                </h6>
            </div>
            <form action="{{ route('pinjaman.store') }}" method="POST">
                @csrf
                <div class="card-body p-4">
                    <div class="form-group mb-4">
                        <label class="small font-weight-bold">Pilih Nasabah / Anggota</label>
                        <select name="nasabah_id" class="form-control select2 @error('nasabah_id') is-invalid @enderror" required>
                            <option value="">-- Cari Nama atau No. Anggota --</option>
                            @foreach($nasabahs as $nasabah)
                                <option value="{{ $nasabah->id }}">{{ $nasabah->nama }} ({{ $nasabah->no_anggota }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="small font-weight-bold">Jumlah Pinjaman (Rp)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text bg-light border-0">Rp</span></div>
                                    <input type="number" name="jumlah_pengajuan" class="form-control font-weight-bold" placeholder="Contoh: 5000000" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group mb-4">
                                <label class="small font-weight-bold">Tenor (Bulan)</label>
                                <input type="number" name="tenor_bulan" class="form-control" placeholder="12" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group mb-4">
                                <label class="small font-weight-bold">Bunga (%)</label>
                                <div class="input-group">
                                    <input type="number" name="bunga_persen" class="form-control" placeholder="1.5" step="0.01" required>
                                    <div class="input-group-append"><span class="input-group-text bg-light border-0">%</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label class="small font-weight-bold">Tujuan Pinjaman / Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Modal usaha toko klontong / Biaya pendidikan..."></textarea>
                    </div>
                </div>
                <div class="card-footer bg-white py-4 d-flex justify-content-between px-4">
                    <a href="{{ route('pinjaman.index') }}" class="btn btn-light px-4 font-weight-bold">Batal</a>
                    <button type="submit" class="btn btn-primary px-5 font-weight-bold rounded-pill shadow">
                        Kirim Pengajuan <i class="fas fa-paper-plane ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection