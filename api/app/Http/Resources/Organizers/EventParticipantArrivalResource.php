<?php

namespace App\Http\Resources\Organizers;

use Illuminate\Http\Resources\Json\JsonResource;

class EventParticipantArrivalResource extends JsonResource
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
            'event_id' => $this->event->uuid,
            // 'user_id' => $this->user->uuid,
            'arrival_date' => $this->arrival_date,
            'user' => [
                'id' => $this->user->uuid,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
            ],
        ];
    }
}
