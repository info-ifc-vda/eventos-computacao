<?php

namespace App\Http\Resources\Organizers;

use App\Http\Resources\AddressResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    #[OA\Schema(
        schema: 'OrganizersEvent',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'string', format: 'uuid', example: '3fa85f64-5717-4562-b3fc-2c963f66afa6'),
            new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-06-09T12:00:00Z'),
            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-06-09T12:30:00Z'),
            new OA\Property(property: 'title', type: 'string', example: 'Festa de Inverno'),
            new OA\Property(property: 'decription', type: 'string', example: 'Evento anual com atrações culturais.'),
            new OA\Property(property: 'cancelled', type: 'boolean', example: false),
            new OA\Property(property: 'cancellation_date', type: 'string', format: 'date', nullable: true, example: '2025-06-15'),
            new OA\Property(property: 'cancellation_description', type: 'string', nullable: true, example: 'Cancelado por questões climáticas.'),
            new OA\Property(property: 'subscription_deadline', type: 'string', format: 'date', example: '2025-07-01'),
            new OA\Property(property: 'payment_deadline', type: 'string', format: 'date', nullable: true, example: '2025-07-10'),
            new OA\Property(
                property: 'banner',
                type: 'object',
                properties: [
                    new OA\Property(property: 'url', type: 'string', format: 'uri', example: 'https://example.com/banner.jpg')
                ]
            ),
            new OA\Property(property: 'estimated_value', type: 'number', format: 'float', nullable: true, example: 1500.75),
            new OA\Property(
                property: 'event_periods',
                type: 'array',
                items: new OA\Items(ref: '#/components/schemas/OrganizersEventPeriod')
            ),
            new OA\Property(
                property: 'location',
                type: 'object',
                properties: [
                    new OA\Property(property: 'address', ref: '#/components/schemas/Address'),
                    new OA\Property(property: 'maps_link', type: 'string', format: 'uri', example: 'https://maps.google.com/?q=-23.55052,-46.633308')
                ]
            )
        ]
    )]
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'title' => $this->title,
            'decription' => $this->description,
            'cancelled' => $this->cancelled,
            'cancellation_date' => $this->cancellation_date,
            'cancellation_description' => $this->cancellation_description,
            'subscription_deadline' => $this->subscription_deadline,
            'payment_deadline' => $this->payment_deadline,
            'banner' => [
                'url' => $this->banner_url,
            ],
            'estimated_value' => $this->estimated_value,
            'event_periods' => EventPeriods::collection($this->event_periods),
            'location' => [
                'address' => new AddressResource($this->location->address),
                'maps_link' => $this->location->maps_link
            ],
        ];
    }
}
