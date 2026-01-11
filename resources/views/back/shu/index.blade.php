@extends('layouts.admin')

@section('title', 'Data SHU')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Riwayat Pembagian SHU</h3>
        <div class="card-tools">
            <a href="{{ route('shu.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-calculator"></i> Hitung SHU Baru
            </a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Tahun</th>
                    <th>Total SHU</th>
                    <th>% Anggota</th>
                    <th>Total Dibagikan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shus as $shu)
                <tr>
                    <td>{{ $shu->tahun }}</td>
                    <td>Rp {{ number_format($shu->total_shu, 0, ',', '.') }}</td>
                    <td>{{ $shu->persentase_anggota }}%</td>
                    <td>Rp {{ number_format($shu->total_dibagikan, 0, ',', '.') }}</td>
                    <td>
                        @if($shu->status == 'published')
                            <span class="badge badge-success">Terpublikasi</span>
                        @else
                            <span class="badge badge-warning">Draft</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('shu.show', $shu->id) }}" class="btn btn-info btn-xs">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        <form action="{{ route('shu.destroy', $shu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data SHU ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data SHU.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer clearfix">
        {{ $shus->links() }}
    </div>
</div>
@endsection
