@extends('layouts.admin')

@section('title', 'Pengajuan Pinjaman Baru')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Pengajuan</h3>
    </div>
    <form action="{{ route('pinjaman.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Nasabah</label>
                <select name="nasabah_id" class="form-control select2">
                    <option value="">-- Pilih Nasabah --</option>
                    @foreach($nasabahs as $nasabah)
                        <option value="{{ $nasabah->id }}">{{ $nasabah->nama }} ({{ $nasabah->no_anggota }})</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jumlah Pengajuan (Rp)</label>
                        <input type="number" name="jumlah_pengajuan" class="form-control" placeholder="Min: 50000">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tenor (Bulan)</label>
                        <input type="number" name="tenor_bulan" class="form-control" placeholder="Contoh: 12">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Bunga (%) / Bulan</label>
                        <input type="number" name="bunga_persen" class="form-control" placeholder="Contoh: 1.5" step="0.01">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Keperluan / Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"></textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Ajukan Pinjaman</button>
            <a href="{{ route('pinjaman.index') }}" class="btn btn-default float-right">Kembali</a>
        </div>
    </form>
</div>
@endsection
