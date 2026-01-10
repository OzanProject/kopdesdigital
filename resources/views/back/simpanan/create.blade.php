@extends('layouts.admin')

@section('title', 'Input Setoran Simpanan')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Setoran</h3>
    </div>
    <form action="{{ route('simpanan.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Pilih Nasabah</label>
                <select name="nasabah_id" class="form-control select2" style="width: 100%;">
                    <option value="">-- Cari Nasabah --</option>
                    @foreach($nasabahs as $nasabah)
                        <option value="{{ $nasabah->id }}">{{ $nasabah->no_anggota }} - {{ $nasabah->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Jenis Simpanan</label>
                <select name="jenis" class="form-control">
                    <option value="pokok">Simpanan Pokok</option>
                    <option value="wajib">Simpanan Wajib</option>
                    <option value="sukarela" selected>Simpanan Sukarela</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah Setoran (Rp)</label>
                <input type="number" name="jumlah" class="form-control" placeholder="0" min="1000">
            </div>
            <div class="form-group">
                <label>Tanggal Transaksi</label>
                <input type="date" name="tanggal_transaksi" class="form-control" value="{{ date('Y-m-d') }}">
            </div>
            <div class="form-group">
                <label>Keterangan (Opsional)</label>
                <input type="text" name="keterangan" class="form-control" placeholder="Catatan transaksi...">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
            <a href="{{ route('simpanan.index') }}" class="btn btn-default float-right">Batal</a>
        </div>
    </form>
</div>
@endsection
