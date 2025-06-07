<?php

namespace App\Http\Resources\Organizers;

use Illuminate\Http\Resources\Json\JsonResource;

class EventExpenseResource extends JsonResource
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
            'updated_at' => $this->updated_at,
            'event_id' => $this->event_id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'proof_access_key' => $this->proof_access_key,
            // 'items' => EventExpenseItemResource::collection($this->items),
            'items_total' => (float) $this->items_total,
        ];
    }
}
