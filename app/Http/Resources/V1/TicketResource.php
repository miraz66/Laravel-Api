<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    // public static $wrap = 'tickets';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'tickets',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->when(
                    request()->routeIs('tickets.show'),
                    $this->description
                ),
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],
            'included' => new UserResource($this->whenLoaded('author')),
            'relationships' => [
                'author' => [
                    'type' => 'users',
                    'id' => $this->user_id
                ],
                'links' => [
                    'self' => route('authors.show', ['author' => $this->user_id]),
                ],
            ],
            'links' => [
                'self' => route('tickets.show', $this->id),
            ],
        ];
    }
}
