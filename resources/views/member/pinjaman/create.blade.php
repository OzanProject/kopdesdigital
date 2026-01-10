@extends('layouts.admin')

@section('title', 'Ajukan Pinjaman')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Formulir Pengajuan Pinjaman</h3>
            </div>
            <form action="{{ route('member.pinjaman.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-info"></i> Informasi!</h5>
                        Pengajuan pinjaman Anda akan ditinjau oleh Admin Koperasi. Bunga dan total pembayaran akan ditentukan setelah disetujui.
                    </div>

                    <div class="form-group">
                        <label for="jumlah">Jumlah Pinjaman (Rp)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" name="jumlah" class="form-control" placeholder="Min. 100.000" min="100000" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tenor">Tenor (Bulan)</label>
                        <select name="tenor" class="form-control" required>
                            <option value="">-- Pilih Jangka Waktu --</option>
                            @php
                                $koperasi = auth()->user()->nasabah->koperasi;
                                $tenorOptions = $koperasi->settings['tenor_options'] ?? [3, 6, 12, 18, 24, 36];
                            @endphp
                            @foreach($tenorOptions as $bulan)
                                <option value="{{ $bulan }}">{{ $bulan }} Bulan</option>
                            @endforeach
                            <option value="custom">Lainnya...</option>
                        </select>
                         <small class="text-muted">Pilih durasi pengembalian pinjaman.</small>
                    </div>

                    <div class="form-group">
                         <label for="keterangan">Keperluan Pinjaman (Opsional)</label>
                         <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Renovasi rumah, biaya pendidikan, dll."></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">Ajukan Pinjaman</button>
                    <a href="{{ route('member.pinjaman.index') }}" class="btn btn-default btn-block mt-2">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
