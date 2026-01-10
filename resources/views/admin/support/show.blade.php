@extends('layouts.admin')

@section('title', 'Respon Tiket #' . $ticket->id)

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <h3 class="profile-username text-center">{{ $ticket->user->name }}</h3>
                <p class="text-muted text-center">{{ $ticket->koperasi->nama ?? 'Koperasi' }}</p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Email</b> <a class="float-right">{{ $ticket->user->email }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Prioritas</b> <a class="float-right">{{ ucfirst($ticket->priority) }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b> <a class="float-right">{{ ucfirst($ticket->status) }}</a>
                    </li>
                </ul>
                
                @if($ticket->status != 'closed')
                <form action="{{ route('admin.support.close', $ticket->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Yakin tutup tiket ini?')">
                        <b>Tutup Tiket</b>
                    </button>
                </form>
                @else
                    <button class="btn btn-secondary btn-block" disabled>Tiket Ditutup</button>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="card direct-chat direct-chat-primary">
            <div class="card-header">
                <h3 class="card-title">{{ $ticket->subject }}</h3>
            </div>
            <div class="card-body">
                <div class="direct-chat-messages" style="height: 400px;">
                    @foreach($ticket->replies as $reply)
                        @if($reply->user_id == Auth::id())
                            <!-- Admin (Me) - Right -->
                            <div class="direct-chat-msg right">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-right">Anda (Support)</span>
                                    <span class="direct-chat-timestamp float-left">{{ $reply->created_at->format('d M H:i') }}</span>
                                </div>
                                @if($reply->user->avatar)
                                    <img class="direct-chat-img" src="{{ asset('storage/'.$reply->user->avatar) }}" alt="Admin">
                                @else
                                    <img class="direct-chat-img" src="{{ asset('adminlte3/dist/img/user1-128x128.jpg') }}" alt="Admin">
                                @endif
                                <div class="direct-chat-text">
                                    {{ $reply->message }}
                                </div>
                            </div>
                        @else
                            <!-- User - Left -->
                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">{{ $reply->user->name }}</span>
                                    <span class="direct-chat-timestamp float-right">{{ $reply->created_at->format('d M H:i') }}</span>
                                </div>
                                @if($reply->user->avatar)
                                    <img class="direct-chat-img" src="{{ asset('storage/'.$reply->user->avatar) }}" alt="User">
                                @else
                                    <img class="direct-chat-img" src="{{ asset('adminlte3/dist/img/user2-160x160.jpg') }}" alt="User">
                                @endif
                                <div class="direct-chat-text">
                                    {{ $reply->message }}
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                @if($ticket->status != 'closed')
                <form action="{{ route('admin.support.reply', $ticket->id) }}" method="post">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="message" placeholder="Tulis balasan..." class="form-control" required>
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </span>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
