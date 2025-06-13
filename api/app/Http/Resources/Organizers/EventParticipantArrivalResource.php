<?php

namespace App\Http\Resources\Organizers;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class EventParticipantArrivalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    #[OA\Schema(
        schema: 'OrganizersEventParticipantArrival',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'string', format: 'uuid', example: 'd48a9972-3b44-4ac5-9b71-a5ffdb45c3e0'),
            new OA\Property(property: 'event_id', type: 'string', format: 'uuid', example: '101e4567-e89b-12d3-a456-426614174000'),
            new OA\Property(property: 'arrival_date', type: 'string', format: 'date', example: '2025-06-10'),
            new OA\Property(
                property: 'user',
                type: 'object',
                properties: [
                    new OA\Property(property: 'id', type: 'string', format: 'uuid', example: '42c1f345-2d8a-4e59-baf3-718faa12c9a7'),
                    new OA\Property(property: 'name', type: 'string', example: 'João da Silva'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'joao@email.com'),
                    new OA\Property(property: 'phone', type: 'string', example: '+55 11 99999-9999'),
                ]
            ),
        ]
    )]
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'event_id' => $this->event->uuid,
            // 'user_id' => $this->user->uuid,
            'arrival_date' => $this->arrival_date,
            'user' => [
                'id' => $this->user->uuid,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
            ],
        ];
    }
}
