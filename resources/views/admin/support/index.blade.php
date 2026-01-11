@extends('layouts.admin')

@section('title', 'Pusat Support (Tiket)')

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
    .badge-soft-warning { background-color: #fef3c7; color: #92400e; }
    .badge-soft-info { background-color: #e0f2fe; color: #0369a1; }
    .badge-soft-danger { background-color: #fee2e2; color: #b91c1c; }
    .badge-soft-secondary { background-color: #f1f5f9; color: #475569; }
</style>

<div class="card border-0 shadow-sm rounded-lg">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 font-weight-bold">Daftar Tiket Masuk</h5>
        <p class="text-muted small mb-0">Kelola keluhan dan pertanyaan dari pengguna koperasi</p>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-modern table-hover m-0">
                <thead>
                    <tr>
                        <th class="px-4">ID Tiket</th>
                        <th>Koperasi / User</th>
                        <th>Subjek Masalah</th>
                        <th class="text-center">Status & Prioritas</th>
                        <th>Update Terakhir</th>
                        <th class="text-right px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr>
                        <td class="align-middle px-4 font-weight-bold text-muted">#{{ $ticket->id }}</td>
                        <td class="align-middle">
                            <div class="font-weight-bold text-dark">{{ $ticket->koperasi->nama ?? 'Sistem Utama' }}</div>
                            <small class="text-muted"><i class="fas fa-user-circle mr-1"></i> {{ $ticket->user->name }}</small>
                        </td>
                        <td class="align-middle">
                            <div class="text-dark">{{ Str::limit($ticket->subject, 45) }}</div>
                        </td>
                        <td class="align-middle text-center">
                            @php
                                $statusClass = match($ticket->status) {
                                    'open' => 'badge-soft-success',
                                    'answered' => 'badge-soft-warning',
                                    'customer_reply' => 'badge-soft-info',
                                    default => 'badge-soft-secondary',
                                };
                                $priorityClass = match($ticket->priority) {
                                    'critical' => 'badge-danger',
                                    'high' => 'badge-warning',
                                    default => 'badge-light border',
                                };
                            @endphp
                            <span class="badge {{ $statusClass }} px-2 py-1 rounded-pill small font-weight-bold mb-1 d-inline-block">
                                {{ strtoupper($ticket->status == 'customer_reply' ? 'User Balas' : $ticket->status) }}
                            </span>
                            <br>
                            <span class="badge {{ $priorityClass }} x-small px-2" style="font-size: 0.65rem;">
                                {{ strtoupper($ticket->priority) }}
                            </span>
                        </td>
                        <td class="align-middle small text-muted">{{ $ticket->updated_at->diffForHumans() }}</td>
                        <td class="align-middle text-right px-4">
                            <a href="{{ route('support-tickets.show', $ticket->id) }}" class="btn btn-primary btn-sm rounded-pill px-3 font-weight-bold shadow-sm">
                                <i class="fas fa-reply mr-1"></i> Respon
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                            <p>Tidak ada tiket support yang memerlukan tindakan saat ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $tickets->links() }}
    </div>
</div>
@endsection