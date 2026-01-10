@extends('layouts.admin')

@section('title', 'Backup Database & File')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Backup Otomatis</h3>
                <div class="card-tools">
                    <form action="{{ route('backups.create') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Buat Backup Baru
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Nama File</th>
                            <th>Ukuran</th>
                            <th>Waktu Backup</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($backups as $backup)
                        <tr>
                            <td>{{ $backup['file_name'] }}</td>
                            <td>{{ $backup['file_size'] }}</td>
                            <td>{{ $backup['last_modified'] }}</td>
                            <td>
                                <a href="{{ route('backups.download', $backup['file_name']) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i> Download
                                </a>
                                <form action="{{ route('backups.destroy', $backup['file_name']) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus backup ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                                 <form action="{{ route('backups.restore', $backup['file_name']) }}" method="POST" class="d-inline" onsubmit="return confirm('PERINGATAN BAHAYA:\n\nApakah Anda yakin ingin me-RESTORE data ini?\n\n1. Semua data saat ini di database akan DIHAPUS dan DITIMPA dengan data dari backup ini.\n2. Proses ini tidak bisa dibatalkan.\n\nKetik OKE jika Anda yakin.');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger" title="Restore Database">
                                        <i class="fas fa-history"></i> Restore
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada file backup tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="alert alert-info">
            <h5><i class="icon fas fa-info"></i> Catatan</h5>
            <ul>
                <li>Backup dilakukan secara otomatis setiap hari pukul 00:00.</li>
                <li>Backup berisi seluruh database dan file yang diupload.</li>
                <li>Simpan file backup di tempat aman (Google Drive / Laptop) secara berkala.</li>
            </ul>
        </div>
        
        <div class="text-right mb-3">
             <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#restoreModal">
                <i class="fas fa-question-circle"></i> Panduan Restore Data
            </button>
        </div>
    </div>
</div>

<!-- Restore Modal -->
<div class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-labelledby="restoreModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreModalLabel">Panduan Restore Database</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Untuk mengembalikan data (Restore) dari file backup:</p>
                <ol>
                    <li><strong>Download</strong> file backup (.zip) yang diinginkan.</li>
                    <li><strong>Ekstrak</strong> file .zip tersebut di komputer Anda.</li>
                    <li>Anda akan mendapatkan file <code>.sql</code> (Database) dan folder file lainnya.</li>
                    <li>Buka aplikasi management database (seperti <strong>phpMyAdmin</strong>, <strong>HeidiSQL</strong>, atau <strong>Laragon Database</strong>).</li>
                    <li>Pilih database <code>db_koperasi</code>.</li>
                    <li>Pilih menu <strong>Import</strong> dan pilih file <code>.sql</code> hasil ekstraksi tadi.</li>
                    <li>Tunggu proses selesai. Data akan kembali ke kondisi saat backup dibuat.</li>
                </ol>
                <div class="alert alert-warning">
                    <small><i class="fas fa-exclamation-triangle"></i> <strong>PERHATIAN:</strong> Proses restore akan <strong>menimpa/menghapus</strong> data yang ada saat ini dengan data dari backup. Pastikan Anda yakin sebelum melakukan import.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection
