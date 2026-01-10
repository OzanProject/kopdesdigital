@extends('layouts.admin')

@section('title', 'Pusat Support (Tiket)')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Tiket Masuk</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Koperasi / User</th>
                            <th>Subjek</th>
                            <th>Status (Prioritas)</th>
                            <th>Terakhir Update</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                        <tr>
                            <td>#{{ $ticket->id }}</td>
                            <td>
                                <strong>{{ $ticket->koperasi->nama ?? 'N/A' }}</strong>
                                <br><small>{{ $ticket->user->name }}</small>
                            </td>
                            <td>{{ Str::limit($ticket->subject, 40) }}</td>
                            <td>
                                @if($ticket->status == 'open')
                                    <span class="badge badge-success">Open</span>
                                @elseif($ticket->status == 'answered')
                                    <span class="badge badge-warning">Dijawab</span>
                                @elseif($ticket->status == 'customer_reply')
                                    <span class="badge badge-info fw-bold">User Balas</span>
                                @else
                                    <span class="badge badge-secondary">Closed</span>
                                @endif
                                
                                <span class="badge badge-{{ $ticket->priority == 'critical' ? 'danger' : ($ticket->priority == 'high' ? 'warning' : 'light') }}">{{ ucfirst($ticket->priority) }}</span>
                            </td>
                            <td>{{ $ticket->updated_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('support-tickets.show', $ticket->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-comment"></i> Respon
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada tiket support.</td>
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
