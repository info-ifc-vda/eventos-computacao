<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

class LoginRequest extends FormRequest
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
        schema: 'AuthLoginRequest',
        type: 'object',
        required: ['username', 'password'],
        properties: [
            new OA\Property(
                property: 'username',
                type: 'string',
                format: 'email',
                example: 'admin@gmail.com'
            ),
            new OA\Property(
                property: 'password',
                type: 'string',
                format: 'password',
                example: 'Yametekudas@1'
            )
        ]
    )]
    public function rules()
    {
        return [
            'username' => ['required', 'email', 'string'],
            'password' => ['required', 'string']
        ];
    }
}
