<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class EventParticipantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    #[OA\Schema(
        schema: 'UsersEventParticipant',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'string', format: 'uuid', example: 'abc123'),
            new OA\Property(property: 'user_id', type: 'string', format: 'uuid'),
            new OA\Property(property: 'event_id', type: 'string', format: 'uuid'),
            new OA\Property(property: 'arrival_date', type: 'string', format: 'date', example: '2025-06-11'),
            new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
        ]
    )]
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user->uuid,
            'event_it' => $this->event->uuid,
            'arrival_date' => $this->arrival_date
        ];
    }
}
