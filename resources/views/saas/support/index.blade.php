@extends('layouts.admin')

@section('title', 'Pusat Bantuan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tiket Saya</h3>
                <div class="card-tools">
                    <a href="{{ route('support.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Buat Tiket Baru
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Subjek</th>
                            <th>Status</th>
                            <th>Prioritas</th>
                            <th>Terakhir Update</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                        <tr>
                            <td>#{{ $ticket->id }}</td>
                            <td>{{ Str::limit($ticket->subject, 50) }}</td>
                            <td>
                                @if($ticket->status == 'open')
                                    <span class="badge badge-success">Open</span>
                                @elseif($ticket->status == 'answered')
                                    <span class="badge badge-warning">Dijawab Admin</span>
                                @elseif($ticket->status == 'customer_reply')
                                    <span class="badge badge-info">Menunggu Respon</span>
                                @else
                                    <span class="badge badge-secondary">Closed</span>
                                @endif
                            </td>
                            <td>
                                @if($ticket->priority == 'critical')
                                    <span class="text-danger fw-bold">CRITICAL</span>
                                @elseif($ticket->priority == 'high')
                                    <span class="text-warning fw-bold">High</span>
                                @else
                                    <span class="text-success">Normal</span>
                                @endif
                            </td>
                            <td>{{ $ticket->updated_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('support.show', $ticket->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('support.destroy', $ticket->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus tiket ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada tiket yang dibuat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
