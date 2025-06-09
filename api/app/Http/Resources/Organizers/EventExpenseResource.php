<?php

namespace App\Http\Resources\Organizers;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class EventExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    #[OA\Schema(
        schema: 'OrganizersEventExpense',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'string', format: 'uuid', example: 'uuid-expense-123'),
            new OA\Property(property: 'description', type: 'string', example: 'Compra de bebidas'),
            new OA\Property(property: 'total_value', type: 'number', format: 'float', example: 205.00),
            new OA\Property(
                property: 'items',
                type: 'array',
                items: new OA\Items(ref: '#/components/schemas/OrganizersEventExpenseItem')
            ),
            new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time'),
        ]
    )]
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'event_id' => $this->event->uuid,
            'user_id' => $this->user->uuid,
            'title' => $this->title,
            'proof_access_key' => $this->proof_access_key,
            // 'items' => EventExpenseItemResource::collection($this->items),
            'items_total' => (float) $this->items_total,
        ];
    }
}
