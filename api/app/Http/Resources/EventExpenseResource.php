<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  mixed  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->uuid,
            'user_id' => $this->user_id,
            'proof_access_key' => $this->proof_access_key,
            'items' => EventExpenseItemResource::collection($this->whenLoaded('items')),
            'total_value' => $this->items_total,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}