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
    // #[OA\Schema(
    //     schema: 'OrganizersEventParticipantArrival',
    //     type: 'object',
    //     properties: [
    //         new OA\Property(property: 'id', type: 'string', format: 'uuid', example: 'd48a9972-3b44-4ac5-9b71-a5ffdb45c3e0'),
    //         new OA\Property(property: 'event_id', type: 'integer', example: 101),
    //         new OA\Property(property: 'user_id', type: 'integer', example: 42),
    //         new OA\Property(property: 'arrival_confirmed', type: 'boolean', example: true),
    //         new OA\Property(property: 'confirmed_at', type: 'string', format: 'date-time', nullable: true, example: '2025-06-10T15:30:00Z'),
    //         new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-06-09T12:00:00Z'),
    //         new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-06-09T12:30:00Z')
    //     ]
    // )]
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'event_id' => $this->event->uuid,
            'user_id' => $this->user->uuid,
            'arrival_date' => $this->arrival_date
        ];
    }
}
