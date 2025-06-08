<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'state' => $this->state,
            'city' => $this->city,
            'neighborhood' => $this->neighborhood,
            'zip_code' => $this->zip_code,
            'street' => $this->street,
            'number' => $this->number,
            'complement' => $this->complement
        ];
    }
}
