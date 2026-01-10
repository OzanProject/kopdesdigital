@extends('layouts.admin')

@section('title', 'Edit Transaksi Simpanan')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Simpanan</h3>
    </div>
    <form action="{{ route('simpanan.update', $simpanan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="nasabah_id">Nasabah</label>
                <select name="nasabah_id" id="nasabah_id" class="form-control select2" required>
                    <option value="">-- Pilih Nasabah --</option>
                    @foreach($nasabahs as $nasabah)
                        <option value="{{ $nasabah->id }}" {{ old('nasabah_id', $simpanan->nasabah_id) == $nasabah->id ? 'selected' : '' }}>
                            {{ $nasabah->no_anggota }} - {{ $nasabah->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="jenis">Jenis Simpanan</label>
                <select name="jenis" id="jenis" class="form-control" required>
                    <option value="pokok" {{ old('jenis', $simpanan->jenis) == 'pokok' ? 'selected' : '' }}>Simpanan Pokok</option>
                    <option value="wajib" {{ old('jenis', $simpanan->jenis) == 'wajib' ? 'selected' : '' }}>Simpanan Wajib</option>
                    <option value="sukarela" {{ old('jenis', $simpanan->jenis) == 'sukarela' ? 'selected' : '' }}>Simpanan Sukarela</option>
                </select>
            </div>

            <div class="form-group">
                <label for="jumlah">Jumlah (Rp)</label>
                <input type="number" name="jumlah" class="form-control" id="jumlah" placeholder="Contoh: 50000" value="{{ old('jumlah', $simpanan->jumlah) }}" required>
            </div>

            <div class="form-group">
                <label for="tanggal_transaksi">Tanggal Transaksi</label>
                <input type="date" name="tanggal_transaksi" class="form-control" id="tanggal_transaksi" value="{{ old('tanggal_transaksi', $simpanan->tanggal_transaksi->format('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan (Opsional)</label>
                <textarea name="keterangan" class="form-control" id="keterangan" rows="3">{{ old('keterangan', $simpanan->keterangan) }}</textarea>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('simpanan.index') }}" class="btn btn-default">Batal</a>
        </div>
    </form>
</div>
@endsection
