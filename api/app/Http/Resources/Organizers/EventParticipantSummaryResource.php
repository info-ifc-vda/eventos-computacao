<?php

namespace App\Http\Resources\Organizers;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class EventParticipantSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    #[OA\Schema(
        schema: 'OrganizersEventParticipantSummary',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'string', format: 'uuid', example: 'b5a8c321-6ecf-4d3a-bd6d-d5f9a2f5e9e9'),
            new OA\Property(property: 'event_id', type: 'integer', example: 12),
            new OA\Property(property: 'user_id', type: 'integer', example: 34),
            new OA\Property(property: 'has_paid', type: 'boolean', example: true),
            new OA\Property(property: 'payment_method', type: 'string', example: 'credit_card'),
            new OA\Property(property: 'checked_in', type: 'boolean', example: false),
            new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-06-01T10:00:00Z'),
            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-06-08T16:30:00Z')
        ]
    )]
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
