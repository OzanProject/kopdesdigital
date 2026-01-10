@extends('layouts.admin')

@section('title', 'Detail Pinjaman')

@section('content')
<div class="row">
    <!-- Kolom Detail Pinjaman -->
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <h3 class="profile-username text-center">Pinjaman #{{ $pinjaman->id }}</h3>
                <p class="text-muted text-center">{{ $pinjaman->nasabah->nama }} ({{ $pinjaman->nasabah->no_anggota }})</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Pokok Pinjaman</b> <a class="float-right">Rp {{ number_format($pinjaman->jumlah_disetujui ?? $pinjaman->jumlah_pengajuan, 0, ',', '.') }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Bunga / Bulan</b> <a class="float-right">{{ $pinjaman->bunga_persen }}%</a>
                    </li>
                    <li class="list-group-item">
                        <b>Tenor</b> <a class="float-right">{{ $pinjaman->tenor_bulan }} Bulan</a>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b> 
                        <a class="float-right">
                            <span class="badge badge-{{ $pinjaman->status == 'approved' ? 'success' : ($pinjaman->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($pinjaman->status) }}
                            </span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <b>Tanggal Pengajuan</b> <a class="float-right">{{ $pinjaman->tanggal_pengajuan->format('d/m/Y') }}</a>
                    </li>
                     @if($pinjaman->tanggal_disetujui)
                    <li class="list-group-item">
                        <b>Tanggal Disetujui</b> <a class="float-right">{{ $pinjaman->tanggal_disetujui->format('d/m/Y') }}</a>
                    </li>
                    @endif
                </ul>

                <a href="{{ route('pinjaman.index') }}" class="btn btn-secondary btn-block">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Kolom Jadwal Angsuran -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#jadwal" data-toggle="tab">Jadwal Angsuran</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="jadwal">
                        @if($pinjaman->status != 'approved' && $pinjaman->status != 'lunas')
                            <div class="alert alert-info">Jadwal angsuran akan muncul setelah pinjaman disetujui.</div>
                        @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped text-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Jumlah Tagihan</th>
                                        <th>Status</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pinjaman->angsurans as $angsuran)
                                    <tr>
                                        <td>{{ $angsuran->angsuran_ke }}</td>
                                        <td>{{ $angsuran->jatuh_tempo->format('d/m/Y') }}</td>
                                        <td>Rp {{ number_format($angsuran->jumlah_bayar, 0, ',', '.') }}</td>
                                        <td>
                                            @if($angsuran->status == 'paid')
                                                <span class="badge badge-success">Lunas</span>
                                            @elseif($angsuran->status == 'late')
                                                <span class="badge badge-danger">Terlambat</span>
                                            @else
                                                <span class="badge badge-secondary">Belum Bayar</span>
                                            @endif
                                        </td>
                                        <td>{{ $angsuran->tanggal_bayar ? $angsuran->tanggal_bayar->format('d/m/Y') : '-' }}</td>
                                        <td>
                                            @if($angsuran->status != 'paid')
                                            <a href="{{ route('angsuran.edit', $angsuran->id) }}" class="btn btn-primary btn-xs">
                                                <i class="fas fa-money-bill-wave"></i> Bayar
                                            </a>
                                            @else
                                            <i class="fas fa-check text-success"></i>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
