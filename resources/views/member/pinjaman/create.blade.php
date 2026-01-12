@extends('layouts.admin')

@section('title', 'Ajukan Pinjaman Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 font-weight-bold text-primary"><i class="fas fa-file-invoice-dollar mr-2"></i> Formulir Aplikasi Kredit</h6>
            </div>
            
            <form action="{{ route('member.pinjaman.store') }}" method="POST">
                @csrf
                <div class="card-body p-4">
                    <div class="alert bg-light border border-info rounded-lg mb-4 d-flex align-items-center">
                        <i class="fas fa-shield-alt text-info mr-3 fa-2x"></i>
                        <div class="small text-dark">
                            <strong>Informasi Penting:</strong><br>
                            Setiap pengajuan akan diverifikasi oleh Admin.
                            @php
                                $bunga = auth()->user()->nasabah->koperasi->settings['default_bunga_persen'] ?? 0;
                            @endphp
                            @if($bunga > 0)
                                Suku bunga yang berlaku saat ini adalah <strong>{{ $bunga }}% per bulan</strong> (Flat).
                            @else
                                Suku bunga dan jadwal angsuran akan ditetapkan secara resmi setelah status disetujui.
                            @endif
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="small font-weight-bold">Nominal Pinjaman Yang Diajukan</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white border-0 font-weight-bold">Rp</span>
                            </div>
                            <input type="number" name="jumlah" class="form-control form-control-lg font-weight-bold border-light bg-light" 
                                   placeholder="Masukkan angka tanpa titik/koma" min="100000" required>
                        </div>
                        <small class="form-text text-muted">Minimal pengajuan: Rp 100.000</small>
                    </div>

                    <div class="form-group mb-4">
                        <label class="small font-weight-bold">Jangka Waktu (Tenor)</label>
                        <select name="tenor" class="form-control form-control-lg fs-6 custom-select border-light bg-light" required>
                            <option value="">-- Pilih Durasi Pengembalian --</option>
                            @php
                                $koperasi = auth()->user()->nasabah->koperasi;
                                $tenorOptions = $koperasi->settings['tenor_options'] ?? [3, 6, 12, 18, 24, 36];
                            @endphp
                            @foreach($tenorOptions as $bulan)
                                <option value="{{ $bulan }}">{{ $bulan }} Bulan</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="small font-weight-bold">Keperluan Pinjaman</label>
                        <textarea name="keterangan" class="form-control border-light bg-light" rows="3" 
                                  placeholder="Jelaskan secara singkat tujuan pinjaman Anda..."></textarea>
                    </div>
                </div>

                <div class="card-footer bg-white border-0 py-4 d-flex justify-content-between px-4">
                    <a href="{{ route('member.pinjaman.index') }}" class="btn btn-light px-4 font-weight-bold">Batal</a>
                    <button type="submit" class="btn btn-primary px-5 font-weight-bold rounded-pill shadow" onclick="return confirm('Kirim pengajuan pinjaman sekarang?')">
                        Kirim Pengajuan <i class="fas fa-paper-plane ml-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection