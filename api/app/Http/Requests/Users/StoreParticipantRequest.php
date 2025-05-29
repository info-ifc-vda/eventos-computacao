<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

class StoreParticipantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    #[OA\Schema(
        schema: 'UsersStoreParticipant',
        type: 'object',
        properties: [
            new OA\Property(
                property: 'event_id',
                type: 'string',
                format: 'uuid',
            ),
            new OA\Property(
                property: 'user_id',
                type: 'string',
                format: 'uuid'
            ),
        ]
    )]
    public function rules()
    {
        return [
            //
        ];
    }
}
