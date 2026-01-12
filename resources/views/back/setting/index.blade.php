@extends('layouts.admin')

@section('title', 'Identitas Koperasi')

@section('content')
<style>
    .coop-card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .logo-preview-wrapper {
        position: relative;
        display: inline-block;
        padding: 10px;
        background: #f8fafc;
        border-radius: 20px;
        border: 2px dashed #e2e8f0;
    }
    .logo-preview {
        width: 140px;
        height: 140px;
        object-fit: contain;
        border-radius: 12px;
    }
    .section-divider {
        display: flex;
        align-items: center;
        margin: 2rem 0 1.5rem;
    }
    .section-divider span {
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        background: #fff;
        padding-right: 15px;
    }
    .section-divider div {
        flex-grow: 1;
        height: 1px;
        background: #e2e8f0;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-xl-3">
            <div class="card coop-card-modern shadow-sm mb-4">
                <div class="card-header bg-dark py-4 text-center">
                    <div class="logo-preview-wrapper mb-3">
                        @if($koperasi->logo)
                            <img class="logo-preview" src="{{ asset('storage/' . $koperasi->logo) }}" alt="Logo">
                        @else
                            <img class="logo-preview" src="https://ui-avatars.com/api/?name={{ urlencode($koperasi->nama) }}&background=random&size=128" alt="Logo">
                        @endif
                    </div>
                    <h5 class="text-white font-weight-bold mb-0">{{ $koperasi->nama }}</h5>
                    <span class="badge badge-primary mt-2 px-3 py-2 rounded-pill shadow-sm">
                        {{ strtoupper($koperasi->status) }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush small font-weight-bold">
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="text-muted">Badan Hukum</span>
                            <span>{{ $koperasi->no_badan_hukum ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="text-muted">Paket SaaS</span>
                            <span class="text-primary">{{ $koperasi->paket_langganan ?? 'Standard' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="alert alert-info border-0 shadow-sm rounded-lg small">
                <i class="fas fa-lightbulb mr-2"></i> 
                Informasi ini akan muncul pada Kop Surat laporan dan struk transaksi anggota.
            </div>
        </div>

        <div class="col-md-8 col-xl-9">
            <div class="card coop-card-modern">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="font-weight-bold mb-0">Konfigurasi Instansi</h5>
                    <p class="text-muted small">Kelola data legalitas dan operasional koperasi Anda</p>
                </div>

                <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body px-4 pt-0">
                        <div class="section-divider">
                            <span>Informasi Dasar & Legal</span>
                            <div></div>
                        </div>

                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Nama Resmi Koperasi</label>
                                    <input type="text" name="nama" class="form-control form-control-lg fs-6 shadow-sm" value="{{ old('nama', $koperasi->nama) }}" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="small font-weight-bold">No. Badan Hukum</label>
                                    <input type="text" name="no_badan_hukum" class="form-control form-control-lg fs-6 shadow-sm" value="{{ old('no_badan_hukum', $koperasi->no_badan_hukum) }}" placeholder="AHU-xxx.xx.xx">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Email Kantor</label>
                                    <input type="email" name="email" class="form-control shadow-sm" value="{{ old('email', $koperasi->email) }}" placeholder="office@koperasi.id">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Telepon / WhatsApp</label>
                                    <input type="text" name="kontak" class="form-control shadow-sm" value="{{ old('kontak', $koperasi->kontak) }}" placeholder="0812xxxx">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Website Resmi</label>
                                    <input type="url" name="website" class="form-control shadow-sm" value="{{ old('website', $koperasi->website) }}" placeholder="https://...">
                                </div>
                            </div>
                        </div>

                        <div class="section-divider">
                            <span>Sistem & Operasional</span>
                            <div></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small font-weight-bold text-primary">Zona Waktu Lokal</label>
                                    <select name="timezone" class="form-control shadow-sm" required>
                                        <option value="Asia/Jakarta" {{ $koperasi->timezone == 'Asia/Jakarta' ? 'selected' : '' }}>WIB (Asia/Jakarta)</option>
                                        <option value="Asia/Makassar" {{ $koperasi->timezone == 'Asia/Makassar' ? 'selected' : '' }}>WITA (Asia/Makassar)</option>
                                        <option value="Asia/Jayapura" {{ $koperasi->timezone == 'Asia/Jayapura' ? 'selected' : '' }}>WIT (Asia/Jayapura)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="small font-weight-bold text-primary">Bunga / Bulan (%)</label>
                                    <div class="input-group shadow-sm">
                                        <input type="number" step="0.01" name="default_bunga_persen" class="form-control" 
                                               value="{{ old('default_bunga_persen', $koperasi->settings['default_bunga_persen'] ?? 0) }}" 
                                               placeholder="0.0">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-white border-left-0">%</span>
                                        </div>
                                    </div>
                                    <small class="text-muted">Persentase bunga flat.</small>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="small font-weight-bold">Opsi Tenor Kredit (Bulan)</label>
                                    @php
                                        $currentTenors = $koperasi->settings['tenor_options'] ?? [3, 6, 12, 24];
                                        $tenorString = is_array($currentTenors) ? implode(', ', $currentTenors) : $currentTenors;
                                    @endphp
                                    <input type="text" name="tenor_options" class="form-control shadow-sm" value="{{ old('tenor_options', $tenorString) }}" placeholder="3, 6, 12, 18, 24">
                                    <small class="text-muted">Daftar pilihan tenor yang tersedia saat pengajuan pinjaman.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="small font-weight-bold">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control shadow-sm" rows="2">{{ old('alamat', $koperasi->alamat) }}</textarea>
                        </div>

                        <div class="form-group mb-4">
                            <label class="small font-weight-bold">Upload Logo (PNG/JPG)</label>
                            <div class="custom-file">
                                <input type="file" name="logo" class="custom-file-input" id="logoInput">
                                <label class="custom-file-label font-weight-bold border-0 shadow-sm" for="logoInput">Pilih file logo baru...</label>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 pb-4 px-4 d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary px-5 py-2 font-weight-bold rounded-pill shadow">
                            <i class="fas fa-save mr-2"></i> Update Identitas Koperasi
                        </button>
                        <button type="reset" class="btn btn-light px-4 py-2 font-weight-bold rounded-pill">
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('.custom-file-input').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
            
            // Preview Logo
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.logo-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endpush