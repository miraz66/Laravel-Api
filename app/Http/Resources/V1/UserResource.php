<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'users',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
                $this->mergeWhen(
                    request()->routeIs('users.*'),
                    [
                        'email_verified' => $this->email_verified_at,
                        'created_at' => $this->created_at,
                        'updated_at' => $this->updated_at,
                    ]
                ),
                'included' => TicketResource::collection($this->whenLoaded('tickets')),
                'links' => [
                    'self' => route('users.show', $this->id),
                ]

                // 'email_verified_at' => $this->when(
                //     request()->routeIs('users.*'),
                //     $this->email_verified_at
                // ),
                // 'created_at' => $this->when(
                //     request()->routeIs('users.*'),
                //     $this->created_at
                // ),
                // 'updated_at' => $this->when(
                //     request()->routeIs('users.*'),
                //     $this->updated_at
                // )
            ]
        ];
    }
}
