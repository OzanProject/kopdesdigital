@extends('layouts.admin')

@section('title', 'Manajemen SHU')

@section('content')
<style>
    .table-modern thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #64748b;
        border-top: none;
    }
    .badge-published { background-color: #dcfce7; color: #15803d; }
    .badge-draft { background-color: #fef3c7; color: #92400e; }
</style>

<div class="card border-0 shadow-sm rounded-lg">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0 font-weight-bold">Riwayat Pembagian SHU</h5>
                <p class="text-muted small mb-0">Kelola dan publikasikan hasil usaha tahunan anggota</p>
            </div>
            <div class="col-md-6 text-md-right mt-2 mt-md-0">
                <a href="{{ route('shu.create') }}" class="btn btn-primary btn-sm font-weight-bold px-3 rounded-pill shadow-sm">
                    <i class="fas fa-calculator mr-1"></i> Hitung SHU Baru
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern table-hover m-0">
                <thead>
                    <tr>
                        <th class="px-4">Tahun Buku</th>
                        <th>Total SHU Bersih</th>
                        <th class="text-center">% Bagian Anggota</th>
                        <th>Total Dibagikan</th>
                        <th class="text-center">Status</th>
                        <th class="text-right px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shus as $shu)
                    <tr>
                        <td class="align-middle px-4 font-weight-bold text-dark">{{ $shu->tahun }}</td>
                        <td class="align-middle font-weight-bold">Rp {{ number_format($shu->total_shu, 0, ',', '.') }}</td>
                        <td class="align-middle text-center">
                            <span class="text-primary font-weight-bold">{{ $shu->persentase_anggota }}%</span>
                        </td>
                        <td class="align-middle text-success font-weight-bold">Rp {{ number_format($shu->total_dibagikan, 0, ',', '.') }}</td>
                        <td class="align-middle text-center">
                            @if($shu->status == 'published')
                                <span class="badge badge-published px-3 py-2 rounded-pill">TERPUBLIKASI</span>
                            @else
                                <span class="badge badge-draft px-3 py-2 rounded-pill">DRAFT</span>
                            @endif
                        </td>
                        <td class="align-middle text-right px-4">
                            <div class="btn-group shadow-sm">
                                <a href="{{ route('shu.show', $shu->id) }}" class="btn btn-white btn-sm text-info px-3" title="Detail">
                                    <i class="fas fa-eye mr-1"></i> Detail
                                </a>
                                <form action="{{ route('shu.destroy', $shu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data SHU ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-white btn-sm text-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-box-open fa-3x mb-3 opacity-25"></i>
                            <p>Belum ada kalkulasi SHU yang tersimpan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0">
        {{ $shus->links() }}
    </div>
</div>
@endsection