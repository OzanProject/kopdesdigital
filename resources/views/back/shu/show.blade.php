@extends('layouts.admin')

@section('title', 'Detail SHU ' . $shu->tahun)

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-widget widget-user-2">
            <div class="widget-user-header bg-warning">
                 <h3>SHU Tahun {{ $shu->tahun }}</h3>
                 <h5>Status: {{ ucfirst($shu->status) }}</h5>
            </div>
            <div class="card-footer p-0">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            Total SHU <span class="float-right badge bg-primary">Rp {{ number_format($shu->total_shu, 0, ',', '.') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            Total Dibagikan ({{ $shu->persentase_anggota }}%) <span class="float-right badge bg-success">Rp {{ number_format($shu->total_dibagikan, 0, ',', '.') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            Jasa Modal ({{ $shu->persentase_modal }}%) <span class="float-right badge bg-info">Rp {{ number_format($shu->members->sum('shu_modal'), 0, ',', '.') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            Jasa Usaha ({{ $shu->persentase_usaha }}%) <span class="float-right badge bg-secondary">Rp {{ number_format($shu->members->sum('shu_usaha'), 0, ',', '.') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        @if($shu->status == 'draft')
        <div class="card">
            <div class="card-body">
                <p class="text-muted">Data ini masih Draft. Anggota belum bisa melihatnya. Pastikan perhitungan sudah benar sebelum publikasi.</p>
                <form action="{{ route('shu.publish', $shu->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-block" onclick="return confirm('Yakin ingin mempublikasikan SHU ini?')">
                        <i class="fas fa-check-circle"></i> Publikasikan
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Rincian Per Anggota</h3>
                <div class="card-tools">
                    <a href="{{ route('shu.index') }}" class="btn btn-tool" title="Kembali">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0" style="height: 500px;">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>Nama Anggota</th>
                            <th>Jasa Modal</th>
                            <th>Jasa Usaha</th>
                            <th>Total Diterima</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shu->members as $member)
                        <tr>
                            <td>{{ $member->nasabah->nama }}</td>
                            <td>Rp {{ number_format($member->shu_modal, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($member->shu_usaha, 0, ',', '.') }}</td>
                            <td class="font-weight-bold text-success">Rp {{ number_format($member->total_diterima, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
