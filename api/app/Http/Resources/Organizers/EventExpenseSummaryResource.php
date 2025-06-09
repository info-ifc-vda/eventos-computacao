<?php

namespace App\Http\Resources\Organizers;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class EventExpenseSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    // #[OA\Schema(
    //     schema: 'OrganizersEventExpenseSummary',
    //     type: 'object',
    //     properties: [
    //         new OA\Property(property: 'id', type: 'string', format: 'uuid', example: '3fa85f64-5717-4562-b3fc-2c963f66afa6'),
    //         new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-06-09T12:00:00Z'),
    //         new OA\Property(property: 'user_id', type: 'integer', example: 42),
    //         new OA\Property(property: 'event_id', type: 'integer', example: 101),
    //         new OA\Property(property: 'proof_access_key', type: 'string', example: 'abc123xyz'),
    //         new OA\Property(property: 'title', type: 'string', example: 'Despesas com Alimentação'),
    //         new OA\Property(property: 'items_total', type: 'number', format: 'float', example: 378.45)
    //     ]
    // )]
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'created_at' => $this->created_at,
            'user_id' => $this->user->uuid,
            'event_id' => $this->event->uuid,
            'proof_access_key' => $this->proof_access_key,
            'title' => $this->title,
            'items_total' => (float) $this->items_total,
            // 'items_count' => $this->items->count(),
        ];
    }
}
