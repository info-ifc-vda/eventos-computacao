<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventExpenseItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     * @todo Documentação
     */
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'description' => $this->description,
            'unit_value' => $this->unit_value,
            'quantity' => $this->quantity,
            'discount' => $this->discount,
            'total_value' => $this->total_value,
        ];
    }
}
