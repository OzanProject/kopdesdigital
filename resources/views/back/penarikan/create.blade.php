@extends('layouts.admin')

@section('title', 'Form Penarikan Simpanan')

@section('content')
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Ambil Simpanan Sukarela</h3>
    </div>
    <form action="{{ route('penarikan.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="alert alert-info">
                Hanya <b>Simpanan Sukarela</b> yang dapat ditarik sewaktu-waktu.
            </div>
            
            <div class="form-group">
                <label>Nasabah</label>
                <select name="nasabah_id" class="form-control select2">
                    <option value="">-- Pilih Nasabah --</option>
                    @foreach($nasabahs as $nasabah)
                        <option value="{{ $nasabah->id }}">
                            {{ $nasabah->nama }} (Validasi Saldo akan dilakukan saat Submit)
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label>Jumlah Penarikan (Rp)</label>
                <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}">
                @error('jumlah') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Tanggal Penarikan</label>
                <input type="date" name="tanggal_penarikan" class="form-control" value="{{ date('Y-m-d') }}">
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan') }}</textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning">Proses Penarikan</button>
            <a href="{{ route('penarikan.index') }}" class="btn btn-default float-right">Batal</a>
        </div>
    </form>
</div>
@endsection
