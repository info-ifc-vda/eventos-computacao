<?php

namespace App\Http\Resources\Organizers;

use App\Http\Resources\AddressResource;
use App\Http\Resources\EventBankDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;

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
                // 'maps_link' => $this->location->maps_link
            ],
            'bank_details' => new EventBankDetailsResource($this->bank_details)
        ];
    }
}
