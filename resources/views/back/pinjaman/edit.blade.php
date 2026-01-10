@extends('layouts.admin')

@section('title', 'Review Pinjaman')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Detail Pengajuan</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Nasabah</dt>
                    <dd class="col-sm-8">{{ $pinjaman->nasabah->nama }}</dd>
                    
                    <dt class="col-sm-4">No Anggota</dt>
                    <dd class="col-sm-8">{{ $pinjaman->nasabah->no_anggota }}</dd>

                    <dt class="col-sm-4">Pengajuan</dt>
                    <dd class="col-sm-8">Rp {{ number_format($pinjaman->jumlah_pengajuan) }}</dd>

                    <dt class="col-sm-4">Tenor</dt>
                    <dd class="col-sm-8">{{ $pinjaman->tenor_bulan }} Bulan</dd>

                    <dt class="col-sm-4">Bunga</dt>
                    <dd class="col-sm-8">{{ $pinjaman->bunga_persen }}%</dd>

                    <dt class="col-sm-4">Keperluan</dt>
                    <dd class="col-sm-8">{{ $pinjaman->keterangan ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Keputusan</h3>
            </div>
            <form action="{{ route('pinjaman.update', $pinjaman->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Jumlah Disetujui (Rp)</label>
                        <input type="number" name="jumlah_disetujui" class="form-control" value="{{ $pinjaman->jumlah_pengajuan }}">
                        <small class="text-muted">Bisa diubah jika tidak menyetujui penuh.</small>
                    </div>
                    <div class="alert alert-light">
                        <i class="fas fa-info-circle"></i> Dengan menyetujui, jadwal angsuran akan (nanti) digenerate otomatis.
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" name="approve" value="1" class="btn btn-success" onclick="return confirm('Setujui pinjaman ini?')">
                        <i class="fas fa-check"></i> Setujui
                    </button>
                    <button type="submit" name="reject" value="1" class="btn btn-danger float-right" onclick="return confirm('Tolak pinjaman ini?')">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
