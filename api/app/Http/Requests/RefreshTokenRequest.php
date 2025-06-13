<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

class RefreshTokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'AuthRefreshRequest',
        required: ['refresh_token'],
        properties: [
            new OA\Property(property: 'refresh_token', type: 'string', example: 'def50200acb123...')
        ]
    )]
    public function rules()
    {
        return [
            //
        ];
    }
}
