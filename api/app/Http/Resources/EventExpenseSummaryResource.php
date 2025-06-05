<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventExpenseSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * Versão resumida para listagem de despesas
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'user_id' => $this->user_id,
            'user_name' => $this->whenLoaded('user', fn() => $this->user->name),
            'proof_access_key' => $this->proof_access_key,
            'total_value' => $this->items_total,
            'items_count' => $this->whenLoaded('items', fn() => $this->items->count()),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}