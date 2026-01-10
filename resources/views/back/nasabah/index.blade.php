@extends('layouts.admin')

@section('title', 'Data Nasabah')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Daftar Anggota</h3>
        <div class="card-tools d-flex align-items-center ml-auto">
            <!-- Bulk Actions (Hidden by default) -->
            <div id="bulk-buttons" class="btn-group mr-2" style="display: none;">
                <button type="button" class="btn btn-info btn-sm" onclick="submitBulkAction('{{ route('nasabah.print_cards') }}')">
                    <i class="fas fa-id-card"></i> Cetak Kartu
                </button>
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmBulkDelete()">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>

            <!-- Search Form -->
            <form action="{{ route('nasabah.index') }}" method="GET" class="mr-2">
                <div class="input-group input-group-sm" style="width: 200px;">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nasabah..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Primary Actions -->
            <div class="btn-group">
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-file-excel"></i> Import
                </button>
                <a href="{{ route('nasabah.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <!-- Unified Bulk Form -->
            <form id="bulk-action-form" method="POST" target="_blank" style="display: none;">
                @csrf
                <input type="hidden" name="ids" id="bulk-action-ids">
            </form>

            <table class="table table-bordered table-striped table-hover text-nowrap">
                <thead>
                    <tr>
                        <th style="width: 1%" class="text-center">
                            <input type="checkbox" id="check-all">
                        </th>
                        <th style="width: 1%">#</th>
                        <th>No Anggota</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIK</th>
                        <th>Telepon</th>
                        <th class="text-center">Status</th>
                        <th style="width: 15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nasabahs as $nasabah)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" class="check-item" value="{{ $nasabah->id }}">
                        </td>
                        <td>{{ $loop->iteration + $nasabahs->firstItem() - 1 }}</td>
                        <td>{{ $nasabah->no_anggota }}</td>
                        <td>{{ $nasabah->nama }}</td>
                        <td>{{ $nasabah->user->email ?? '-' }}</td>
                        <td>{{ $nasabah->nik }}</td>
                        <td>{{ $nasabah->telepon }}</td>
                        <td class="text-center">
                            <span class="badge badge-{{ $nasabah->status == 'active' ? 'success' : 'danger' }}">
                                {{ ucfirst($nasabah->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a class="btn btn-info btn-sm" href="{{ route('nasabah.edit', $nasabah->id) }}" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('nasabah.destroy', $nasabah->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data nasabah.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $nasabahs->withQueryString()->links() }}
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data Nasabah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('nasabah.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih File Excel (.xlsx, .xls, .csv)</label>
                        <input type="file" name="file" class="form-control" required>
                    </div>
                    <p class="text-muted small">
                        Pastikan format file sesuai. <a href="{{ route('nasabah.template') }}"><i class="fas fa-download"></i> Download Template</a>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Import</button>
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

        // Individual Check
        $('.check-item').change(function() {
            if ($('.check-item:checked').length == $('.check-item').length) {
                $('#check-all').prop('checked', true);
            } else {
                $('#check-all').prop('checked', false);
            }
            toggleBulkButton();
        });

        function toggleBulkButton() {
            if ($('.check-item:checked').length > 0) {
                $('#bulk-buttons').fadeIn();
            } else {
                $('#bulk-buttons').fadeOut();
            }
        }
    });

    function submitBulkAction(url) {
        var selectedIds = [];
        $('.check-item:checked').each(function() {
            selectedIds.push($(this).val());
        });

        var form = $('#bulk-action-form');
        form.attr('action', url);
        form.find('input[name="ids[]"]').remove(); // Clear old
        
        // Remove method field if it exists (for delete which might need DELETE method spoofing, but Print is POST)
        form.find('input[name="_method"]').remove();

        $.each(selectedIds, function(index, value) {
            form.append('<input type="hidden" name="ids[]" value="'+value+'">');
        });
        
        form.submit();
    }

    function confirmBulkDelete() {
        if (confirm('Apakah Anda yakin ingin menghapus data yang dipilih? Data yang dihapus tidak dapat dikembalikan.')) {
            var form = $('#bulk-action-form');
            form.append('<input type="hidden" name="_method" value="DELETE">'); // Restore DELETE method spoofing
            submitBulkAction('{{ route("nasabah.bulk_destroy") }}');
        }
    }
</script>
@endpush
@endsection
