@extends('layouts.admin')

@section('title', 'Manajemen Anggota')

@section('content')
<style>
    .table-modern thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #64748b;
        border-top: none;
    }
    .badge-soft-success { background-color: #dcfce7; color: #15803d; }
    .badge-soft-danger { background-color: #fee2e2; color: #b91c1c; }
    .btn-action { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; }
</style>

<div class="card border-0 shadow-sm rounded-lg">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-12 col-md-4 mb-3 mb-md-0">
                <h5 class="mb-0 font-weight-bold">Daftar Anggota</h5>
                <p class="text-muted small mb-0">Total {{ $nasabahs->total() }} anggota terdaftar</p>
            </div>
            
            <div class="col-12 col-md-8">
                <div class="d-flex flex-wrap justify-content-md-end align-items-center">
                    <div id="bulk-buttons" class="mr-3 mb-2 mb-md-0 animate__animated animate__fadeIn" style="display: none;">
                        <div class="btn-group shadow-sm">
                            <button type="button" class="btn btn-outline-info btn-sm font-weight-bold" onclick="submitBulkAction('{{ route('nasabah.print_cards') }}')">
                                <i class="fas fa-id-card mr-1"></i> Cetak Kartu
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm font-weight-bold" onclick="confirmBulkDelete()">
                                <i class="fas fa-trash mr-1"></i> Hapus Terpilih
                            </button>
                        </div>
                    </div>
        
                    <form action="{{ route('nasabah.index') }}" method="GET" class="mr-2 mb-2 mb-md-0">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" name="search" class="form-control border-right-0" placeholder="Cari nama/NIK..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-secondary border-left-0">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
        
                    <div class="btn-group mb-2 mb-md-0 shadow-sm">
                        <button type="button" class="btn btn-outline-success btn-sm font-weight-bold" data-toggle="modal" data-target="#importModal">
                            <i class="fas fa-file-excel mr-1"></i> Import
                        </button>
                        <a href="{{ route('nasabah.create') }}" class="btn btn-primary btn-sm font-weight-bold px-3">
                            <i class="fas fa-plus mr-1"></i> Tambah Anggota
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <form id="bulk-action-form" method="POST" target="_blank" style="display: none;">
                @csrf
                <input type="hidden" name="ids" id="bulk-action-ids">
            </form>

            <table class="table table-modern table-hover m-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 40px;">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="check-all">
                                <label class="custom-control-label" for="check-all"></label>
                            </div>
                        </th>
                        <th>Info Anggota</th>
                        <th>Kontak & Identitas</th>
                        <th class="text-center">Status</th>
                        <th class="text-right px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nasabahs as $nasabah)
                    <tr>
                        <td class="text-center align-middle">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input check-item" id="chk-{{ $nasabah->id }}" value="{{ $nasabah->id }}">
                                <label class="custom-control-label" for="chk-{{ $nasabah->id }}"></label>
                            </div>
                        </td>
                        <td class="align-middle">
                            <div class="font-weight-bold text-dark">{{ $nasabah->nama }}</div>
                            <div class="small text-muted">{{ $nasabah->no_anggota }}</div>
                        </td>
                        <td class="align-middle">
                            <div class="small"><i class="fas fa-envelope mr-1 text-muted"></i> {{ $nasabah->user->email ?? '-' }}</div>
                            <div class="small"><i class="fas fa-id-card mr-1 text-muted"></i> {{ $nasabah->nik }}</div>
                            <div class="small"><i class="fab fa-whatsapp mr-1 text-muted"></i> {{ $nasabah->telepon }}</div>
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge {{ $nasabah->status == 'active' ? 'badge-soft-success' : 'badge-soft-danger' }} px-3 py-2 rounded-pill font-weight-bold">
                                {{ strtoupper($nasabah->status) }}
                            </span>
                        </td>
                        <td class="text-right align-middle px-4">
                            <div class="btn-group shadow-sm">
                                <a class="btn btn-white btn-sm text-info btn-action" href="{{ route('nasabah.edit', $nasabah->id) }}" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('nasabah.destroy', $nasabah->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus anggota ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-white btn-sm text-danger btn-action" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-users-slash fa-3x text-light mb-3"></i>
                            <p class="text-muted">Belum ada data nasabah ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="small text-muted">Menampilkan {{ $nasabahs->count() }} dari {{ $nasabahs->total() }} data</div>
            <div>{{ $nasabahs->withQueryString()->links() }}</div>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0">
                <h5 class="modal-title font-weight-bold">Import Data Anggota</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('nasabah.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4">
                    <div class="form-group mb-4">
                        <label class="small font-weight-bold">File Excel (.xlsx, .xls, .csv)</label>
                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="fileImport" required>
                            <label class="custom-file-label" for="fileImport">Pilih file...</label>
                        </div>
                    </div>
                    <div class="p-3 bg-light rounded-lg">
                        <p class="small text-muted mb-0">
                            <i class="fas fa-info-circle mr-1"></i> Gunakan format standar sistem agar data terbaca sempurna.
                            <br><a href="{{ route('nasabah.template') }}" class="font-weight-bold">Download Template Excel</a>
                        </p>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-light font-weight-bold px-4 rounded-pill" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold px-4 rounded-pill">Proses Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        // Toggle Check All
        $('#check-all').click(function() {
            $('.check-item').prop('checked', this.checked);
            toggleBulkButton();
        });

        $('.check-item').change(function() {
            $('#check-all').prop('checked', $('.check-item:checked').length == $('.check-item').length);
            toggleBulkButton();
        });

        function toggleBulkButton() {
            if ($('.check-item:checked').length > 0) {
                $('#bulk-buttons').fadeIn();
            } else {
                $('#bulk-buttons').fadeOut();
            }
        }

        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });

    function submitBulkAction(url) {
        var form = $('#bulk-action-form');
        form.attr('action', url);
        form.find('input[name="ids[]"]').remove();
        form.find('input[name="_method"]').remove();

        $('.check-item:checked').each(function() {
            form.append('<input type="hidden" name="ids[]" value="'+$(this).val()+'">');
        });
        form.submit();
    }

    function confirmBulkDelete() {
        if (confirm('Yakin ingin menghapus data terpilih? Tindakan ini permanen.')) {
            var form = $('#bulk-action-form');
            form.append('<input type="hidden" name="_method" value="DELETE">');
            submitBulkAction('{{ route("nasabah.bulk_destroy") }}');
        }
    }
</script>
@endpush
@endsection