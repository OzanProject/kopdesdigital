@extends('layouts.admin')

@section('title', 'Detail Tiket #' . $ticket->id)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <!-- DIRECT CHAT -->
        <div class="card card-primary card-outline direct-chat direct-chat-primary">
            <div class="card-header">
                <h3 class="card-title">{{ $ticket->subject }}</h3>
                <div class="card-tools">
                    <span class="badge badge-info">Prioritas: {{ ucfirst($ticket->priority) }}</span>
                    @if($ticket->status == 'closed')
                        <span class="badge badge-secondary">Closed</span>
                    @else
                        <span class="badge badge-success">Open</span>
                    @endif
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages" style="height: 400px;">
                    
                    @foreach($ticket->replies as $reply)
                        @if($reply->user_id == Auth::id())
                            <!-- Message. Default to the right -->
                            <div class="direct-chat-msg right">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-right">Anda</span>
                                    <span class="direct-chat-timestamp float-left">{{ $reply->created_at->format('d M H:i') }}</span>
                                </div>
                                @if($reply->user->avatar)
                                    <img class="direct-chat-img" src="{{ asset('storage/'.$reply->user->avatar) }}" alt="User Image">
                                @else
                                    <img class="direct-chat-img" src="{{ asset('adminlte3/dist/img/user2-160x160.jpg') }}" alt="User Image">
                                @endif
                                <div class="direct-chat-text">
                                    {{ $reply->message }}
                                </div>
                            </div>
                        @else
                            <!-- Message. Default to the left -->
                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">{{ $reply->user->name }} (Admin)</span>
                                    <span class="direct-chat-timestamp float-right">{{ $reply->created_at->format('d M H:i') }}</span>
                                </div>
                                @if($reply->user->avatar)
                                    <img class="direct-chat-img" src="{{ asset('storage/'.$reply->user->avatar) }}" alt="Message User Image">
                                @else
                                    <img class="direct-chat-img" src="{{ asset('adminlte3/dist/img/user1-128x128.jpg') }}" alt="Message User Image">
                                @endif
                                <div class="direct-chat-text">
                                    {{ $reply->message }}
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
                <!--/.direct-chat-messages-->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                @if($ticket->status != 'closed')
                <form action="{{ route('support.reply', $ticket->id) }}" method="post">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="message" placeholder="Ketik balasan..." class="form-control" required>
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </span>
                    </div>
                </form>
                @else
                    <div class="alert alert-secondary text-center">
                        Tiket ini telah ditutup.
                    </div>
                @endif
            </div>
            <!-- /.card-footer-->
        </div>
        <!--/.direct-chat -->
    </div>
</div>
@endsection
