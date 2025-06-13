<?php

namespace App\Http\Resources\Organizers;

use Illuminate\Http\Resources\Json\JsonResource;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'OrganizersEventParticipantArrival',
    type: 'object',
    required: ['id', 'event_id', 'user_id', 'arrival_date'],
    properties: [
        new OA\Property(property: "id", type: "string", format: "uuid", example: "17f8fbbd-4d7b-4bcb-888a-f7c23b350573"),
        new OA\Property(property: "event_id", type: "string", format: "uuid", example: "17f8fbbd-4d7b-4bcb-888a-f7c23b350573"),
        new OA\Property(property: "user_id", type: "string", format: "uuid", example: "17f8fbbd-4d7b-4bcb-888a-f7c23b350573"),
        new OA\Property(property: "arrival_date", type: "string", format: "date-time", example: "2024-06-10T12:00:00Z"),
    ]
)]

class EventParticipantArrivalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    // TODO: Documentação
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
