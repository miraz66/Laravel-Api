<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Filters\V1\TicketFilter;
use App\Http\Requests\Api\V1\ReplaceTicketRequest;
use App\Http\Requests\Api\V1\StoreTicketRequest;
use App\Http\Resources\V1\TicketResource;
use App\Models\Ticket;
use App\Traits\ApiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorTicketsController extends ApiController
{

    public function index($authorId, TicketFilter $filters)
    {
        return TicketResource::collection(
            Ticket::where('user_id', $authorId)
                ->filter($filters)
                ->paginate(10)
        );
    }

    public function store($authorId, StoreTicketRequest $request)
    {
        $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $authorId,
        ];

        $ticket = Ticket::create($model);

        return new TicketResource($ticket);
    }

    public function replace(ReplaceTicketRequest $request, $authorId, $ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);
            $model = [
                'title' => $request->input('data.attributes.title'),
                'description' => $request->input('data.attributes.description'),
                'status' => $request->input('data.attributes.status'),
                'user_id' => $ticket->user_id,
            ];

            $ticket->update($model);
            return new TicketResource($ticket);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket ' . $ticket_id . ' not be found', 404);
        }
    }

    public function destroy($authorId, $ticketId)
    {
        try {
            // $ticket = Ticket::findOrFail($ticketId);
            $ticket = Ticket::where('user_id', $authorId)->findOrFail($ticketId);

            // if ($ticket->user_id === $authorId) {
            //     $ticket->delete();
            //     return $this->ok('Ticket ' . $ticketId . ' deleted successfully');
            // }

            $ticket->delete();
            return $this->ok('Ticket ' . $ticketId . ' deleted successfully');
        } catch (ModelNotFoundException $exception) {
            if ($ticketId !== $authorId) {
                return $this->error('Author and ticket does not match', 404);
            }
            return $this->error('Ticket ' . $ticketId . ' not be found', 404);
        }
    }
}
