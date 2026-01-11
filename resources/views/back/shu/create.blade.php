@extends('layouts.admin')

@section('title', 'Hitung Pembagian SHU')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 font-weight-bold text-primary"><i class="fas fa-percentage mr-2"></i> Formulasi Alokasi SHU</h6>
            </div>
            <form action="{{ route('shu.store') }}" method="POST">
                @csrf
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="small font-weight-bold">Tahun Buku</label>
                                <select name="tahun" class="form-control">
                                    @for($i = date('Y')-1; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}" {{ old('tahun', date('Y')-1) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="small font-weight-bold">Total SHU Bersih Koperasi (Rp)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text bg-light border-0">Rp</span></div>
                                    <input type="number" name="total_shu" class="form-control font-weight-bold text-primary" placeholder="0" min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-light rounded-lg border border-dashed my-4">
                        <h6 class="font-weight-bold mb-3"><i class="fas fa-project-diagram text-info mr-2"></i> Konfigurasi Distribusi Anggota</h6>
                        <div class="row text-center">
                            <div class="col-md-4">
                                <label class="small font-weight-bold d-block">Porsi Anggota (%)</label>
                                <input type="number" name="persentase_anggota" class="form-control text-center mx-auto" value="70" style="max-width: 100px;">
                                <small class="text-muted">Dari Total SHU</small>
                            </div>
                            <div class="col-md-4">
                                <label class="small font-weight-bold d-block">Jasa Modal (%)</label>
                                <input type="number" name="persentase_modal" class="form-control text-center mx-auto text-success" value="60" style="max-width: 100px;">
                                <small class="text-muted">Berdasarkan Simpanan</small>
                            </div>
                            <div class="col-md-4">
                                <label class="small font-weight-bold d-block">Jasa Usaha (%)</label>
                                <input type="number" name="persentase_usaha" class="form-control text-center mx-auto text-warning" value="40" style="max-width: 100px;">
                                <small class="text-muted">Berdasarkan Pinjaman</small>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info border-0 rounded-lg small mb-0">
                        <i class="fas fa-lightbulb mr-2"></i> 
                        Sistem akan menghitung secara otomatis proporsi setiap anggota berdasarkan riwayat saldo simpanan dan partisipasi pinjaman mereka selama tahun buku tersebut.
                    </div>
                </div>
                <div class="card-footer bg-white py-4 d-flex justify-content-between px-4">
                    <a href="{{ route('shu.index') }}" class="btn btn-light px-4 font-weight-bold">Batal</a>
                    <button type="submit" class="btn btn-primary px-5 font-weight-bold rounded-pill shadow">
                        Hitung & Simpan Draft <i class="fas fa-chevron-right ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection