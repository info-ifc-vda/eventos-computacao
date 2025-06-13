<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class UserSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    #[\OpenApi\Attributes\Schema(
        schema: 'UserSummary',
        type: 'object',
        properties: [
            new \OpenApi\Attributes\Property(
                property: 'id',
                type: 'string',
                format: 'uuid',
                example: 'a1b2c3d4-e5f6-7890-abcd-1234567890ef'
            ),
            new \OpenApi\Attributes\Property(
                property: 'name',
                type: 'string',
                example: 'Maria Souza'
            ),
        ]
    )]
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'name' => $this->name,
        ];
    }
}
