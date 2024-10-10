<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Models\Ticket;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Requests\Api\V1\UpdateTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\User;
use App\Policies\V1\TicketPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TicketController extends ApiController
{
    protected $policyClass = TicketPolicy::class; // Policy class name
    public function index(TicketFilter $filters)
    {
        return TicketResource::collection(Ticket::filter($filters)->paginate(10));
    }

    public function store(StoreTicketRequest $request)
    {
        try {
            $user = User::findOrFail($request->input('data.relationships.author.data.id'));
        } catch (ModelNotFoundException $exception) {
            return $this->ok('Author not found', [
                'error' => 'The protected author does not exist',
            ]);
        }
        $ticket = Ticket::create($request->mappedAttributes());

        return new TicketResource($ticket);
    }

    public function show(Ticket $ticket)
    {
        if ($this->include('author')) {
            return new TicketResource($ticket->load('user'));
        }

        return new TicketResource($ticket);
    }

    public function update(UpdateTicketRequest $request, $ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);

            // Policy
            $this->isAble(
                'update',
                $ticket
            );

            $ticket->update($request->mappedAttributes());
            return new TicketResource($ticket);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket ' . $ticket_id . ' not be found', 404);
        } catch (AuthorizationException $exception) {
            return $this->error($exception->getMessage(), 403);
        }
    }

    public function replace(ReplaceTicketRequest $request, $ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);
            $ticket->update($request->mappedAttributes());

            return new TicketResource($ticket);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket ' . $ticket_id . ' not be found', 404);
        }
    }

    public function destroy($ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);
            $ticket->delete();

            return $this->ok('Ticket deleted successfully');
        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket not be found', 404);
        }
    }
}
