@extends('layouts.admin')

@section('title', 'Hitung SHU')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Formulasi Pembagian SHU</h3>
            </div>
            <form action="{{ route('shu.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Tahun Buku</label>
                        <select name="tahun" class="form-control">
                            @for($i = date('Y')-1; $i <= date('Y'); $i++)
                                <option value="{{ $i }}" {{ old('tahun', date('Y')-1) == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Total Sisa Hasil Usaha (SHU) Bersih (Rp)</label>
                        <input type="number" name="total_shu" class="form-control" value="{{ old('total_shu') }}" placeholder="Contoh: 100000000" min="0" required>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="callout callout-info">
                                <h5><i class="fas fa-info-circle"></i> Rumus Pembagian</h5>
                                <p>Total Dibagikan ke Anggota = <b>Total SHU × % Anggota</b></p>
                                <p>Dari Total Dibagikan, dipecah menjadi:</p>
                                <ul>
                                    <li><b>Jasa Modal</b>: Berdasarkan total simpanan anggota.</li>
                                    <li><b>Jasa Usaha</b>: Berdasarkan partisipasi pinjaman anggota.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>% SHU untuk Anggota</label>
                                <div class="input-group">
                                    <input type="number" name="persentase_anggota" class="form-control" value="70" min="1" max="100" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <small class="text-muted">Persentase dari Total SHU.</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Alokasi Jasa Modal</label>
                                <div class="input-group">
                                    <input type="number" name="persentase_modal" class="form-control" value="60" min="0" max="100" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <small class="text-muted">Dari bagian anggota.</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Alokasi Jasa Usaha</label>
                                <div class="input-group">
                                    <input type="number" name="persentase_usaha" class="form-control" value="40" min="0" max="100" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <small class="text-muted">Dari bagian anggota.</small>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Hitung & Simpan Draft</button>
                    <a href="{{ route('shu.index') }}" class="btn btn-default">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
