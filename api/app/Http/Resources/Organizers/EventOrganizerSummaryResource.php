<?php

namespace App\Http\Resources\Organizers;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class EventOrganizerSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    #[OA\Schema(
        schema: 'OrganizersEventOrganizerSummary',
        type: 'object',
        required: ['id', 'created_at', 'updated_at', 'event_id', 'user_id'],
        properties: [
            new OA\Property(property: 'id', type: 'string', format: 'uuid', example: 'a1b2c3d4-e5f6-7g8h-9i10-jk11lmn12opq'),
            new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-06-09T12:00:00Z'),
            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-06-09T12:30:00Z'),
            new OA\Property(property: 'event_id', type: 'string', format: 'uuid', example: '101e4567-e89b-12d3-a456-426614174000'),
            new OA\Property(property: 'user_id', type: 'string', format: 'uuid', example: '42c1f345-2d8a-4e59-baf3-718faa12c9a7'),
        ]
    )]
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
