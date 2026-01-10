@extends('layouts.admin')

@section('title', 'Bayar Angsuran')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Form Pembayaran Angsuran Ke-{{ $angsuran->angsuran_ke }}</h3>
            </div>
            <form action="{{ route('angsuran.update', $angsuran->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <dl>
                        <dt>Nasabah</dt>
                        <dd>{{ $angsuran->pinjaman->nasabah->nama }}</dd>
                        
                        <dt>Jatuh Tempo</dt>
                        <dd>{{ $angsuran->jatuh_tempo->format('d F Y') }}</dd>

                        <dt>Tagihan Pokok + Bunga</dt>
                        <dd class="text-primary font-weight-bold">Rp {{ number_format($angsuran->jumlah_bayar, 0, ',', '.') }}</dd>
                    </dl>
                    <hr>
                    <div class="form-group">
                        <label>Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label>Jumlah Dibayar (Rp)</label>
                        <input type="number" name="jumlah_dibayar" class="form-control" value="{{ old('jumlah_dibayar', $angsuran->jumlah_bayar) }}">
                        <small class="text-muted">Minimal sebesar tagihan.</small>
                    </div>
                    <div class="form-group">
                        <label>Denda (Rp)</label>
                        <input type="number" name="denda" class="form-control" value="0">
                        <small class="text-muted">Isi jika ada keterlambatan.</small>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-save"></i> Simpan Pembayaran
                    </button>
                    <a href="{{ route('pinjaman.show', $angsuran->pinjaman_id) }}" class="btn btn-default btn-block mt-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
