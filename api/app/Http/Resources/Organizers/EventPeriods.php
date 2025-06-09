<?php

namespace App\Http\Resources\Organizers;

use Illuminate\Http\Resources\Json\JsonResource;

class EventPeriods extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    #[OA\Schema(
        schema: 'OrganizersEventPeriod',
        type: 'object',
        properties: [
            new OA\Property(property: 'date', type: 'string', format: 'date', example: '2025-08-01'),
            new OA\Property(property: 'opening_time', type: 'string', format: 'time', example: '18:00:00'),
            new OA\Property(property: 'closing_time', type: 'string', format: 'time', example: '23:00:00')
        ]
    )]
    public function toArray($request)
    {
        return [
            'date' => $this->date,
            'opening_time' => $this->opening_time,
            'closing_time' => $this->closing_time
        ];
    }
}
