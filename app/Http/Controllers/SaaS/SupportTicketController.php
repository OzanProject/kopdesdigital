<?php

namespace App\Http\Controllers\SaaS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\TicketReply;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
            
        return view('saas.support.index', compact('tickets'));
    }

    public function create()
    {
        return view('saas.support.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high,critical',
            'message' => 'required|string',
        ]);

        // Create Ticket
        $ticket = SupportTicket::create([
            'koperasi_id' => Auth::user()->koperasi_id,
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'priority' => $request->priority,
            'status' => 'open',
        ]);

        // Create Initial Message as first reply
        TicketReply::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return redirect()->route('support.index')->with('success', 'Tiket berhasil dibuat.');
    }

    public function show($id)
    {
        $ticket = SupportTicket::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['replies.user' => function($q) {
                $q->withoutGlobalScope('koperasi');
            }])
            ->firstOrFail();
            
        return view('saas.support.show', compact('ticket'));
    }

    public function reply(Request $request, $id)
    {
        $ticket = SupportTicket::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'message' => 'required|string',
        ]);

        TicketReply::create([
            'support_ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        $ticket->update(['status' => 'customer_reply', 'updated_at' => now()]);

        return back()->with('success', 'Balasan terkirim.');
    }

    public function destroy($id)
    {
        $ticket = SupportTicket::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        // Delete replies first (optional if cascade is on DB, but good practice here)
        $ticket->replies()->delete();
        $ticket->delete();

        return redirect()->route('support.index')->with('success', 'Tiket berhasil dihapus.');
    }
}
