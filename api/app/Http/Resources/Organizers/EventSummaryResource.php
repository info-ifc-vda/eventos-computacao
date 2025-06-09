<?php

namespace App\Http\Resources\Organizers;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;
use Whoops\Exception\Formatter;

class EventSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    #[OA\Schema(
        schema: 'OrganizersEventSummary',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'string', format: 'uuid', example: '3fa85f64-5717-4562-b3fc-2c963f66afa6'),
            new OA\Property(property: 'title', type: 'string', example: 'Feira de Ciências 2025'),
            new OA\Property(property: 'cancelled', type: 'boolean', example: false),
            new OA\Property(property: 'event_initial_date', type: 'string', format: 'date', nullable: true, example: '2025-08-12')
        ]
    )]
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'title' => $this->title,
            'cancelled' => $this->cancelled,
            'event_initial_date' => $this->event_opening_hours->orderBy('date', 'asc')->first()?->date,
        ];
    }
}
