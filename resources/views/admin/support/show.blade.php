@extends('layouts.admin')

@section('title', 'Respon Tiket #' . $ticket->id)

@section('content')
<style>
    .chat-card { border: none; border-radius: 16px; height: 600px; display: flex; flex-direction: column; }
    .chat-messages { flex-grow: 1; overflow-y: auto; padding: 20px; background: #f8fafc; }
    
    .msg-bubble { max-width: 80%; padding: 12px 16px; border-radius: 18px; margin-bottom: 4px; position: relative; font-size: 0.95rem; }
    .msg-left .msg-bubble { background: white; border: 1px solid #e2e8f0; border-bottom-left-radius: 4px; color: #1e293b; }
    .msg-right .msg-bubble { background: #0d6efd; color: white; border-bottom-right-radius: 4px; margin-left: auto; }
    
    .chat-meta { font-size: 0.75rem; color: #94a3b8; margin-bottom: 15px; display: block; }
    .msg-right .chat-meta { text-align: right; }
    
    .ticket-sidebar-card { border: none; border-radius: 16px; }
    .avatar-ticket { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-bottom: 10px; border: 2px solid #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
</style>

<div class="row">
    <div class="col-lg-3 mb-4">
        <div class="card ticket-sidebar-card shadow-sm">
            <div class="card-body text-center py-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($ticket->user->name) }}&background=random" class="avatar-ticket">
                <h6 class="font-weight-bold text-dark mb-1">{{ $ticket->user->name }}</h6>
                <p class="small text-muted text-uppercase font-weight-bold mb-3">{{ $ticket->koperasi->nama ?? 'Admin Utama' }}</p>
                
                <hr>
                
                <div class="text-left mb-4">
                    <div class="mb-3">
                        <label class="small text-muted d-block mb-0">Prioritas Tiket</label>
                        <span class="badge badge-{{ $ticket->priority == 'critical' ? 'danger' : 'warning' }} px-3 py-1 rounded-pill">
                            {{ strtoupper($ticket->priority) }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted d-block mb-0">Status Terakhir</label>
                        <span class="badge badge-light border px-3 py-1 rounded-pill">
                            {{ strtoupper($ticket->status) }}
                        </span>
                    </div>
                </div>

                @if($ticket->status != 'closed')
                    <form action="{{ route('admin.support.close', $ticket->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-block btn-sm font-weight-bold rounded-pill" onclick="return confirm('Tandai tiket ini sebagai Selesai/Closed?')">
                            <i class="fas fa-check-double mr-1"></i> Tutup Tiket Ini
                        </button>
                    </form>
                @else
                    <div class="alert alert-secondary py-2 small font-weight-bold">TIKET INI TELAH DITUTUP</div>
                @endif
            </div>
        </div>
        
        <a href="{{ route('support-tickets.index') }}" class="btn btn-light btn-block mt-3 text-muted font-weight-bold rounded-pill">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
        </a>
    </div>
    
    <div class="col-lg-9">
        <div class="card chat-card shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 font-weight-bold text-dark">
                    <i class="fas fa-comments text-primary mr-2"></i> {{ $ticket->subject }}
                </h6>
            </div>
            
            <div class="chat-messages" id="chatbox">
                @foreach($ticket->replies as $reply)
                    @if($reply->user_id == Auth::id())
                        <div class="msg-right mb-3">
                            <div class="msg-bubble shadow-xs">
                                {{ $reply->message }}
                            </div>
                            <small class="chat-meta">Anda • {{ $reply->created_at->translatedFormat('d M, H:i') }}</small>
                        </div>
                    @else
                        <div class="msg-left mb-3">
                            <div class="msg-bubble shadow-xs">
                                {{ $reply->message }}
                            </div>
                            <small class="chat-meta">{{ $reply->user->name }} • {{ $reply->created_at->translatedFormat('d M, H:i') }}</small>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="card-footer bg-white border-top p-3">
                @if($ticket->status != 'closed')
                    <form action="{{ route('admin.support.reply', $ticket->id) }}" method="post">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="message" placeholder="Tulis instruksi atau jawaban Anda..." class="form-control border-0 bg-light rounded-pill px-4" required>
                            <div class="input-group-append ml-2">
                                <button type="submit" class="btn btn-primary rounded-circle shadow-sm" style="width: 45px; height: 45px;">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <p class="text-center text-muted small mb-0 py-2">Tiket ini sudah ditutup. Tidak dapat mengirim balasan lagi.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    // Auto scroll ke bawah saat halaman dimuat
    var chatbox = document.getElementById("chatbox");
    chatbox.scrollTop = chatbox.scrollHeight;
</script>
@endpush
@endsection