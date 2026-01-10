@extends('layouts.admin')

@section('title', 'Riwayat Penarikan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Log Penarikan Simpanan</h3>
        <div class="card-tools">
            <a href="{{ route('penarikan.create') }}" class="btn btn-warning btn-sm">
                <i class="fas fa-minus-circle"></i> Catat Penarikan
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nasabah</th>
                        <th>Jumlah</th>
                        <th>Petugas</th>
                        <th>Ket</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penarikans as $penarikan)
                    <tr>
                        <td>{{ $penarikan->tanggal_penarikan->format('d/m/Y') }}</td>
                        <td>{{ $penarikan->nasabah->nama }} <br> <small>{{ $penarikan->nasabah->no_anggota }}</small></td>
                        <td class="text-danger font-weight-bold">- Rp {{ number_format($penarikan->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $penarikan->user->name ?? '-' }}</td>
                        <td>{{ $penarikan->keterangan }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data penarikan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $penarikans->links() }}
    </div>
</div>
@endsection
