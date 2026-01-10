@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Filter Laporan</h3>
            </div>
            <form action="{{ route('laporan.print') }}" method="GET" target="_blank">
                <div class="card-body">
                    <div class="form-group">
                        <label>Jenis Laporan</label>
                        <select name="jenis_laporan" id="jenis_laporan" class="form-control" onchange="toggleFilters()">
                            <option value="simpanan">Laporan Transaksi Simpanan</option>
                            <option value="pinjaman">Laporan Pinjaman</option>
                            <option value="anggota">Laporan Data Anggota</option>
                            <option value="shu">Laporan Pembagian SHU</option>
                            <option value="cashflow">Laporan Arus Kas (Cashflow)</option>
                        </select>
                    </div>

                    <div class="form-group" id="filter_status" style="display: none;">
                        <label>Status Pinjaman</label>
                        <select name="status" class="form-control">
                            <option value="all">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Disetujui</option>
                            <option value="rejected">Ditolak</option>
                            <option value="lunas">Lunas</option>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Dari Tanggal</label>
                                <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-01') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Sampai Tanggal</label>
                                <input type="date" name="end_date" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-print"></i> Cetak Laporan
                    </button>
                    <small class="text-muted">*Laporan akan terbuka di tab baru (siap cetak/PDF).</small>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    function toggleFilters() {
        var jenis = document.getElementById('jenis_laporan').value;
        var statusFilter = document.getElementById('filter_status');
        
        if (jenis === 'pinjaman') {
            statusFilter.style.display = 'block';
        } else {
            statusFilter.style.display = 'none';
        }
    }
</script>
@endpush
