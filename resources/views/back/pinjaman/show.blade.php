@extends('layouts.admin')

@section('title', 'Detail Pinjaman')

@section('content')
<style>
    .loan-summary-card { background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%); color: white; border-radius: 16px; }
    .timeline-steps { border-left: 2px solid #e2e8f0; padding-left: 20px; position: relative; }
    .timeline-point { width: 12px; height: 12px; background: #0d6efd; border-radius: 50%; position: absolute; left: -7px; top: 5px; }
</style>

<div class="row">
    <div class="col-lg-4">
        <div class="card loan-summary-card border-0 shadow-lg mb-4">
            <div class="card-body p-4">
                <div class="small opacity-75 text-uppercase font-weight-bold ls-1 mb-2">ID Pinjaman #{{ $pinjaman->id }}</div>
                <h4 class="font-weight-bold mb-0">{{ $pinjaman->nasabah->nama }}</h4>
                <p class="small opacity-75 mb-4">{{ $pinjaman->nasabah->no_anggota }}</p>
                
                <div class="p-3 rounded-lg bg-white bg-opacity-10 border border-white border-opacity-10 mb-4">
                    <div class="small opacity-75 mb-1">Total Pokok Disetujui</div>
                    <h3 class="font-weight-bold">Rp {{ number_format($pinjaman->jumlah_disetujui ?? $pinjaman->jumlah_pengajuan, 0, ',', '.') }}</h3>
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <div class="small opacity-75">Bunga/Bulan</div>
                        <div class="font-weight-bold fs-5">{{ $pinjaman->bunga_persen }}%</div>
                    </div>
                    <div class="col-6">
                        <div class="small opacity-75">Durasi Tenor</div>
                        <div class="font-weight-bold fs-5">{{ $pinjaman->tenor_bulan }} Bln</div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white bg-opacity-10 border-0 text-center py-3">
                <span class="badge badge-pill badge-light px-4 py-2 text-primary font-weight-bold text-uppercase">
                    {{ $pinjaman->status }}
                </span>
            </div>
        </div>

        @if($pinjaman->status == 'pending')
        <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
            <div class="card-header bg-warning py-3 text-center">
                <h6 class="mb-0 font-weight-bold">Keputusan Kredit</h6>
            </div>
            <form action="{{ route('pinjaman.update', $pinjaman->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label class="small font-weight-bold">Jumlah Disetujui (Rp)</label>
                        <input type="number" name="jumlah_disetujui" class="form-control form-control-lg font-weight-bold text-success" value="{{ $pinjaman->jumlah_pengajuan }}">
                    </div>
                    <div class="alert bg-light border rounded-lg small mb-0">
                        <i class="fas fa-info-circle mr-1"></i> Menyertujui pinjaman ini akan meng-generate jadwal angsuran secara otomatis.
                    </div>
                </div>
                <div class="card-footer bg-white border-0 d-flex justify-content-between p-3">
                    <button type="submit" name="reject" value="1" class="btn btn-outline-danger font-weight-bold px-4 rounded-pill">Tolak</button>
                    <button type="submit" name="approve" value="1" class="btn btn-success font-weight-bold px-4 rounded-pill shadow">Setujui</button>
                </div>
            </form>
        </div>
        @endif
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-calendar-check mr-2 text-primary"></i> Jadwal & Histori Angsuran</h6>
            </div>
            <div class="card-body p-0">
                @if($pinjaman->status != 'approved' && $pinjaman->status != 'lunas')
                    <div class="text-center py-5">
                        <img src="{{ asset('adminlte3/dist/img/credit/visa.png') }}" class="opacity-25 grayscale mb-3" style="filter: grayscale(100%); width: 60px;">
                        <p class="text-muted">Jadwal angsuran akan muncul di sini setelah status pinjaman <b>Disetujui</b>.</p>
                    </div>
                @else
                <div class="table-responsive">
                    <table class="table table-modern m-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-center">#</th>
                                <th>Jatuh Tempo</th>
                                <th class="text-right">Tagihan</th>
                                <th class="text-center">Status</th>
                                <th class="text-right px-4">Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pinjaman->angsurans as $angsuran)
                            <tr>
                                <td class="text-center align-middle font-weight-bold text-muted">{{ $angsuran->angsuran_ke }}</td>
                                <td class="align-middle">
                                    <div class="font-weight-bold">{{ $angsuran->jatuh_tempo->format('d/m/Y') }}</div>
                                    @if($angsuran->tanggal_bayar)
                                        <small class="text-success font-weight-bold">Dibayar: {{ $angsuran->tanggal_bayar->format('d/m/Y') }}</small>
                                    @endif
                                </td>
                                <td class="align-middle text-right font-weight-bold">Rp {{ number_format($angsuran->jumlah_bayar, 0, ',', '.') }}</td>
                                <td class="align-middle text-center">
                                    @if($angsuran->status == 'paid')
                                        <span class="badge badge-soft-success px-3 py-2 rounded-pill">LUNAS</span>
                                    @elseif($angsuran->status == 'late')
                                        <span class="badge badge-soft-danger px-3 py-2 rounded-pill">TERLAMBAT</span>
                                    @else
                                        <span class="badge badge-soft-warning px-3 py-2 rounded-pill">BELUM BAYAR</span>
                                    @endif
                                </td>
                                <td class="align-middle text-right px-4">
                                    @if($angsuran->status != 'paid')
                                        <a href="{{ route('angsuran.edit', $angsuran->id) }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                                            <i class="fas fa-money-bill-wave mr-1"></i> Bayar
                                        </a>
                                    @else
                                        <div class="bg-success d-inline-flex rounded-circle align-items-center justify-content-center" style="width: 28px; height: 28px;">
                                            <i class="fas fa-check text-white small"></i>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            <div class="card-footer bg-white border-0 py-3 text-center">
                <a href="{{ route('pinjaman.index') }}" class="btn btn-light btn-sm font-weight-bold text-muted px-4 rounded-pill">KEMBALI KE DAFTAR</a>
            </div>
        </div>
    </div>
</div>
@endsection