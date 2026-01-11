@extends('layouts.admin')

@section('title', 'Pusat Laporan Keuangan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 font-weight-bold text-primary">
                    <i class="fas fa-file-invoice mr-2"></i> Parameter Cetak Laporan
                </h6>
            </div>
            <form action="{{ route('laporan.print') }}" method="GET" target="_blank">
                <div class="card-body p-4">
                    <div class="form-group mb-4">
                        <label class="small font-weight-bold">Pilih Jenis Dokumen</label>
                        <select name="jenis_laporan" id="jenis_laporan" class="form-control form-control-lg fs-6" onchange="toggleFilters()">
                            <option value="simpanan">📊 Laporan Transaksi Simpanan</option>
                            <option value="pinjaman">💸 Laporan Pinjaman & Kredit</option>
                            <option value="anggota">👥 Laporan Database Anggota</option>
                            <option value="shu">💰 Laporan Pembagian SHU</option>
                            <option value="cashflow">🔄 Laporan Arus Kas (Cashflow)</option>
                        </select>
                    </div>

                    <div class="form-group mb-4 animate__animated animate__fadeIn" id="filter_status" style="display: none;">
                        <label class="small font-weight-bold">Filter Status Spesifik</label>
                        <select name="status" class="form-control">
                            <option value="all">Semua Status</option>
                            <option value="pending">Menunggu (Pending)</option>
                            <option value="approved">Disetujui (Approved)</option>
                            <option value="rejected">Ditolak (Rejected)</option>
                            <option value="lunas">Selesai (Lunas)</option>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="small font-weight-bold">Mulai Tanggal</label>
                                <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-01') }}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="small font-weight-bold">Sampai Tanggal</label>
                                <input type="date" name="end_date" class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-lg mt-3 border border-dashed text-center">
                        <p class="small text-muted mb-0">
                            <i class="fas fa-info-circle mr-1"></i> Laporan akan dihasilkan dalam format siap cetak atau simpan PDF.
                        </p>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-4">
                    <button type="submit" class="btn btn-primary btn-block btn-lg font-weight-bold rounded-pill shadow">
                        <i class="fas fa-print mr-2"></i> Generate Dokumen Laporan
                    </button>
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
        var statusFilter = $('#filter_status');
        
        if (jenis === 'pinjaman') {
            statusFilter.slideDown();
        } else {
            statusFilter.slideUp();
        }
    }
</script>
@endpush