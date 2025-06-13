<?php

namespace App\Http\Resources\Organizers;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class EventExpenseItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    #[OA\Schema(
        schema: 'OrganizersEventExpenseItem',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'string', format: 'uuid', example: 'ae456f7b-1234-4c9e-9876-a7c61f91f99d'),
            new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2025-06-07T12:34:56Z'),
            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2025-06-07T12:34:56Z'),
            new OA\Property(property: 'description', type: 'string', example: 'Compra de bebidas'),
            new OA\Property(property: 'unit_value', type: 'number', format: 'float', example: 20.50),
            new OA\Property(property: 'quantity', type: 'number', format: 'float', example: 10),
            new OA\Property(property: 'total_value', type: 'number', format: 'float', example: 205.00)
        ]
    )]
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'description' => $this->description,
            'unit_value' => (float) $this->unit_value,
            'quantity' => (float) $this->quantity,
            'total_value' => (float) $this->total_value
        ];
    }
}
