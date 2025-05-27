<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class EventParticipantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
        #[OA\Schema(
        schema: 'UsersEventParticipant',
        type: 'object',
        properties: [
            new OA\Property(
                property: 'id',
                type: 'string',
                format: 'uuid',
            ),
            new OA\Property(
                property: 'verification_code',
                type: 'string'
            ),
        ]
    )]
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
