<?php

namespace App\Http\Resources\Organizers;

use Illuminate\Http\Resources\Json\JsonResource;

class EventExpenseSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'created_at' => $this->created_at,
            'user_id' => $this->user_id,
            'event_id' => $this->event_id,
            'proof_access_key' => $this->proof_access_key,
            'title' => $this->title,
            'items_total' => $this->items_total,
            // 'items_count' => $this->items->count(),
        ];
    }
}
