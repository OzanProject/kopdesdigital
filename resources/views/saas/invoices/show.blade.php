@extends('layouts.admin')

@section('title', 'Detail Invoice #' . $invoice->order_id)

@section('content')
<div class="invoice p-3 mb-3">
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h4>
                @php
                    $appName = \App\Models\SaasSetting::where('key', 'app_name')->value('value') ?? 'KopDes Digital';
                @endphp
                <i class="fas fa-globe"></i> {{ $appName }}
                <small class="float-right">Tanggal: {{ $invoice->created_at->translatedFormat('d F Y') }}</small>
            </h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            Dari (Penyedia Layanan)
            <address>
                <strong>Admin Super SaaS.</strong><br>
                Jakarta, Indonesia<br>
                Email: billing@kopdes.id
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            Kepada (Tenant)
            <address>
                <strong>{{ $invoice->koperasi->nama ?? 'Nama Koperasi' }}</strong><br>
                {{ $invoice->koperasi->alamat ?? 'Alamat belum diisi' }}<br>
                Email: {{ $invoice->koperasi->email ?? '-' }}<br>
                Kontak: {{ $invoice->koperasi->kontak ?? '-' }}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Invoice #{{ $invoice->order_id }}</b><br>
            <br>
            <b>Status:</b> 
            @if($invoice->status == 'paid')
                <span class="badge badge-success">Lunas</span>
            @elseif($invoice->status == 'pending')
                <span class="badge badge-warning">Menunggu Pembayaran</span>
            @else
                <span class="badge badge-danger">{{ ucfirst($invoice->status) }}</span>
            @endif
            <br>
            <b>Paket ID:</b> {{ $invoice->subscription_package_id }}
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Paket Langganan</th>
                        <th>Deskripsi</th>
                        <th>Durasi</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $invoice->package->name ?? 'Paket Tidak Dikenal' }}</td>
                        <td>{{ $invoice->package->description ?? '-' }}</td>
                        <td>{{ $invoice->package->duration_in_days ?? 30 }} Hari</td>
                        <td>Rp {{ number_format($invoice->amount + ($invoice->discount_amount ?? 0), 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-12 col-md-6">
            <p class="lead">Catatan Pembayaran:</p>
            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                @if($invoice->payment_type)
                    Metode: {{ strtoupper(str_replace('_', ' ', $invoice->payment_type)) }}<br>
                @endif
                {{ $invoice->notes ?? 'Tidak ada catatan tambahan.' }}
            </p>
        </div>
        <!-- /.col -->
        <div class="col-12 col-md-6">
            <p class="lead">Ringkasan Tagihan</p>

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>Rp {{ number_format($invoice->amount + ($invoice->discount_amount ?? 0), 0, ',', '.') }}</td>
                    </tr>
                    @if($invoice->discount_amount > 0)
                    <tr>
                        <th>Diskon ({{ $invoice->discount_code ?? '' }})</th>
                        <td>- Rp {{ number_format($invoice->discount_amount, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Total Bayar:</th>
                        <td><b>Rp {{ number_format($invoice->amount, 0, ',', '.') }}</b></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- this row will not appear when printing -->
    <div class="row no-print mt-3">
        <div class="col-12 d-flex flex-column flex-md-row justify-content-between">
            <button onclick="window.print()" class="btn btn-default mb-2 mb-md-0"><i class="fas fa-print"></i> Print Invoice</button>

            <div class="ml-auto">
                @if($invoice->status == 'pending')
                     <form action="{{ route('invoices.approve', $invoice->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Setujui pembayaran ini? Akun koperasi akan diaktifkan.');">
                        @csrf
                        <button type="submit" class="btn btn-success mb-2 mb-md-0 ml-md-2">
                            <i class="fas fa-check-double"></i> Setujui Pembayaran (Manual)
                        </button>
                    </form>
                @endif
                
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary ml-md-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
