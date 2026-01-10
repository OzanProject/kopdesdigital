@extends('layouts.admin')

@section('title', 'Data Invoice & Transaksi')

@section('content')
<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Daftar Semua Invoice Masuk</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="table-invoices" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID Invoice</th>
                        <th>Koperasi (Tenant)</th>
                        <th>Paket</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $inv)
                    <tr>
                        <td><code>#{{ $inv->order_id }}</code></td>
                        <td>{{ $inv->koperasi->nama ?? '-' }}</td>
                        <td>
                            @if($inv->package)
                                <span class="badge badge-info">{{ $inv->package->name }}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>Rp {{ number_format($inv->amount, 0, ',', '.') }}</td>
                        <td>
                            @if($inv->status == 'paid')
                                <span class="badge badge-success">Lunas (Paid)</span>
                            @elseif($inv->status == 'pending')
                                <span class="badge badge-warning">Menunggu (Pending)</span>
                            @elseif($inv->status == 'failed' || $inv->status == 'cancelled')
                                <span class="badge badge-danger">Gagal/Batal</span>
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($inv->status) }}</span>
                            @endif
                        </td>
                        <td>{{ $inv->created_at->translatedFormat('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('invoices.show', $inv->id) }}" class="btn btn-sm btn-primary" title="Lihat Detail">
                                <i class="fas fa-file-invoice"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(function () {
        $("#table-invoices").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "order": [[ 5, "desc" ]], // Order by Date descending
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#table-invoices_wrapper .col-md-6:eq(0)');
    });
</script>
@endpush
