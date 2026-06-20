<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index()
    {
        return SupportTicket::with('user')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'subject' => 'nullable',
            'message' => 'nullable',
            'status'  => 'string',
            'files'   => 'array',
        ]);

        return SupportTicket::create($data);
    }

    public function show(SupportTicket $ticket)
    {
        return $ticket->load('user');
    }

    public function update(Request $request, SupportTicket $ticket)
    {
        $data = $request->validate([
            'status' => 'string',
        ]);

        $ticket->update($data);

        return $ticket;
    }

    public function destroy(SupportTicket $ticket)
    {
        $ticket->delete();
        return ['message' => 'Deleted'];
    }
}
