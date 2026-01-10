<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\TicketReply;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::with(['user' => function($query) {
                $query->withoutGlobalScope('koperasi');
            }, 'user.koperasi', 'koperasi'])
            ->orderByRaw("FIELD(status, 'open', 'customer_reply', 'answered', 'closed')")
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('admin.support.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = SupportTicket::with(['replies.user' => function($q){
            $q->withoutGlobalScope('koperasi');
        }, 'user' => function($q){
            $q->withoutGlobalScope('koperasi');
        }, 'user.koperasi'])->findOrFail($id);
        return view('admin.support.show', compact('ticket'));
    }

    public function reply(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);

        $request->validate([
            'message' => 'required|string',
        ]);

        TicketReply::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        $ticket->update(['status' => 'answered', 'updated_at' => now()]);

        return back()->with('success', 'Balasan terkirim.');
    }

    public function close($id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $ticket->update(['status' => 'closed']);
        return back()->with('success', 'Tiket ditutup.');
    }
}
