<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
        // codigo para aplicar mascara de telefone, ex de "49912345678" vai para  "(49) 91234-5678"
        $phone = $this->phone;
        $phone = substr($phone, 0, 0).'('.substr($phone, 0);
        $phone = substr($phone, 0, 3).')'.substr($phone, 3);
        $phone = substr($phone, 0, 4).' '.substr($phone, 4);
        $phone = substr($phone, 0, 10).'-'.substr($phone, 10);
        return [
            'id' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified' => $this->email_verified_at ? true : false,
            'phone' => $phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'permissions' => $this->permissions->pluck('permission')->toArray()
        ];
    }
}
