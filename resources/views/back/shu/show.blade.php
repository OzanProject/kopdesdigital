@extends('layouts.admin')

@section('title', 'Rincian SHU ' . $shu->tahun)

@section('content')
<style>
    .shu-summary-card { border: none; border-radius: 16px; overflow: hidden; }
    .nav-pills .nav-link.active { background-color: #0d6efd; box-shadow: 0 4px 10px rgba(13,110,253,0.2); }
</style>

<div class="row">
    <div class="col-lg-4">
        <div class="card shu-summary-card shadow-sm mb-4">
            <div class="card-header bg-dark text-white text-center py-4">
                <h6 class="text-uppercase small mb-1 opacity-75">Tahun Buku</h6>
                <h2 class="font-weight-bold mb-0">{{ $shu->tahun }}</h2>
                <span class="badge {{ $shu->status == 'published' ? 'badge-success' : 'badge-warning' }} mt-2 px-3">
                    {{ strtoupper($shu->status) }}
                </span>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-muted">Total SHU Bersih</span>
                        <span class="font-weight-bold">Rp {{ number_format($shu->total_shu, 0, ',', '.') }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3 bg-light">
                        <span class="text-muted font-weight-bold">Bagian Anggota ({{ $shu->persentase_anggota }}%)</span>
                        <span class="font-weight-bold text-success">Rp {{ number_format($shu->total_dibagikan, 0, ',', '.') }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-muted">Alokasi Jasa Modal</span>
                        <span class="font-weight-bold text-primary">Rp {{ number_format($shu->members->sum('shu_modal'), 0, ',', '.') }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <span class="text-muted">Alokasi Jasa Usaha</span>
                        <span class="font-weight-bold text-warning">Rp {{ number_format($shu->members->sum('shu_usaha'), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($shu->status == 'draft')
        <div class="card border-0 shadow-sm rounded-lg overflow-hidden mb-4">
            <div class="card-body p-4 text-center">
                <p class="text-muted small mb-4">Data ini masih bersifat <b>Draft</b>. Publikasikan agar anggota dapat melihat rincian SHU mereka di dashboard masing-masing.</p>
                <form action="{{ route('shu.publish', $shu->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-block font-weight-bold py-2 rounded-pill shadow-sm" onclick="return confirm('Publikasikan sekarang?')">
                        <i class="fas fa-check-circle mr-1"></i> Publikasikan Sekarang
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-lg h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 font-weight-bold">Rincian Pembagian Per Anggota</h6>
                <a href="{{ route('shu.index') }}" class="btn btn-light btn-sm text-muted">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 600px;">
                    <table class="table table-head-fixed text-nowrap m-0">
                        <thead>
                            <tr>
                                <th class="bg-light">Nama Anggota</th>
                                <th class="bg-light text-right">Jasa Modal</th>
                                <th class="bg-light text-right">Jasa Usaha</th>
                                <th class="bg-light text-right px-4">Total Terima</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shu->members as $member)
                            <tr>
                                <td class="align-middle font-weight-bold text-dark">{{ $member->nasabah->nama }}</td>
                                <td class="align-middle text-right">Rp {{ number_format($member->shu_modal, 0, ',', '.') }}</td>
                                <td class="align-middle text-right">Rp {{ number_format($member->shu_usaha, 0, ',', '.') }}</td>
                                <td class="align-middle text-right px-4">
                                    <span class="font-weight-bold text-success">Rp {{ number_format($member->total_diterima, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection