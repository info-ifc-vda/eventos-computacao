<?php

namespace App\Http\Resources\Organizers;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'OrganizersUpdateEvent',
    type: 'object',
    required: [...],
    properties: [
        new OA\Property(property: "id", type: "string", format: "uuid", example: "17f8fbbd-4d7b-4bcb-888a-f7c23b350573"),
        new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2024-06-10T12:00:00Z"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2024-06-10T12:00:00Z"),
        new OA\Property(property: "event_id", type: "string", format: "uuid", example: "17f8fbbd-4d7b-4bcb-888a-f7c23b350573"),
        new OA\Property(property: "user_id", type: "string", format: "uuid", example: "17f8fbbd-4d7b-4bcb-888a-f7c23b350573"),
    ]
)]

class EventOrganizerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'event_id' => $this->event->uuid,
            'user_id' => $this->user->uuid,
        ];
    }
}
