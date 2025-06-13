<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    #[OA\Schema(
        schema: 'User',
        type: 'object',
        properties: [
            new OA\Property(property: 'id', type: 'string', format: 'uuid', example: 'abc123-uuid'),
            new OA\Property(property: 'name', type: 'string', example: 'João da Silva'),
            new OA\Property(property: 'email', type: 'string', format: 'email', example: 'joao@email.com'),
            new OA\Property(property: 'email_verified', type: 'boolean', example: true),
            new OA\Property(property: 'phone', type: 'string', example: '(49) 91234-5678'),
            new OA\Property(property: 'created_at', type: 'string', format: 'date-time', example: '2024-06-11T15:30:00Z'),
            new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', example: '2024-06-11T18:45:00Z'),
            new OA\Property(
                property: 'permissions',
                type: 'array',
                items: new OA\Items(type: 'string'),
                example: ['admin', 'edit-users']
            ),
        ]
    )]
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
