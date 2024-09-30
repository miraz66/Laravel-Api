<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;

class TicketController extends Controller
{
    public function index()
    {
        return Ticket::all();
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create($request->validated());
        return response()->json($ticket, 201);
    }

    public function show(Ticket $ticket)
    {
        return response()->json($ticket);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->validated());
        return response()->json($ticket);
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response()->json(null, 204);
    }
}
