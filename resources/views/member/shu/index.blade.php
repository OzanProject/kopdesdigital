@extends('layouts.admin')

@section('title', 'Riwayat SHU Saya')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Penerimaan SHU</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Tahun Buku</th>
                            <th>Jasa Modal</th>
                            <th>Jasa Usaha</th>
                            <th>Total Diterima</th>
                            <th>Tanggal Dibagikan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shu_members as $item)
                        <tr>
                            <td>{{ $item->shu->tahun }}</td>
                            <td>Rp {{ number_format($item->shu_modal, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->shu_usaha, 0, ',', '.') }}</td>
                            <td class="text-success font-weight-bold">Rp {{ number_format($item->total_diterima, 0, ',', '.') }}</td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada riwayat SHU.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $shu_members->links() }}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <h5><i class="icon fas fa-info"></i> Informasi SHU</h5>
            SHU (Sisa Hasil Usaha) dibagikan setiap akhir tahun buku berdasarkan:
            <ul>
                <li><b>Jasa Modal</b>: Dihitung dari partisipasi simpanan Anda.</li>
                <li><b>Jasa Usaha</b>: Dihitung dari partisipasi pinjaman/transaksi Anda.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
