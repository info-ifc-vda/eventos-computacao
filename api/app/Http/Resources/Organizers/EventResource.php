<?php

namespace App\Http\Resources\Organizers;

use App\Http\Resources\AddressResource;
use App\Http\Resources\EventBankDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "OrganizersEvent",
    type: "object",
    properties: [
        new OA\Property(property: "id", type: "string", format: "uuid", example: "17f8fbbd-4d7b-4bcb-888a-f7c23b350573"),
        new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2024-06-10T12:00:00Z"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2024-06-10T12:00:00Z"),
        new OA\Property(property: "title", type: "string", example: "Evento de Teste"),
        new OA\Property(property: "decription", type: "string", example: "Este é um evento de teste criado pelo seeder."),
        new OA\Property(property: "cancelled", type: "boolean", example: false),
        new OA\Property(property: "cancellation_date", type: "string", format: "date-time", nullable: true, example: null),
        new OA\Property(property: "cancellation_description", type: "string", nullable: true, example: null),
        new OA\Property(property: "subscription_deadline", type: "string", format: "date-time", example: "2024-06-17T12:00:00Z"),
        new OA\Property(property: "payment_deadline", type: "string", format: "date-time", example: "2024-06-24T12:00:00Z"),
        new OA\Property(property: "banner", type: "object", properties: [
            new OA\Property(property: "url", type: "string", example: "https://placehold.co/600x400/orange/white?text=Banner+do+Evento")
        ]),
        new OA\Property(property: "estimated_value", type: "number", format: "float", example: 100.00),
        new OA\Property(property: "event_periods", type: "array", items: new OA\Items(type: "object")),
        new OA\Property(property: "location", type: "object", properties: [
            new OA\Property(property: "address", type: "object"),
            new OA\Property(property: "maps_link", type: "string", example: "https://maps.google.com/?q=..."),
        ]),
        new OA\Property(property: "bank_details", type: "object"),
    ]
)]
class EventResource extends JsonResource
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
                'url' => $this->getBannerUrl(),
            ],
            'estimated_value' => (float) $this->estimated_value,
            'event_periods' => EventPeriodsResource::collection($this->event_periods),
            'location' => [
                'address' => new AddressResource($this->location->address),
                'maps_link' => $this->location->maps_link
            ],
            'bank_details' => new EventBankDetailsResource($this->bank_details)
        ];
    }
}
