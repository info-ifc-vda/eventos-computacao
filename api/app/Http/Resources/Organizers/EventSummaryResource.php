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
            new OA\Property(
                property: 'id',
                type: 'string',
                format: 'uuid',
            ),
            new OA\Property(
                property: 'title',
                type: 'string'
            ),
            new OA\Property(
                property: 'cancelled',
                type: 'boolean',
            ),
            new OA\Property(
                property: 'event_initial_date',
                type: 'string',
                format: 'date'
            )
        ]
    )]
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'title' => $this->title,
            'cancelled' => $this->cancelled,
            'event_initial_date' => $this->event_periods()->orderBy('date', 'asc')->first()?->date,
            'banner' => ['url'=> $this->getBannerUrl()]
        ];
    }
}
