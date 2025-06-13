<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

class UpdateUserPassword extends FormRequest
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
        schema: 'UsersUpdatePassword',
        required: ['old_password', 'password', 'password_confirmation'],
        properties: [
            new OA\Property(
                property: 'old_password',
                type: 'string',
                format: 'password',
                example: 'senhaAntiga123!'
            ),
            new OA\Property(
                property: 'password',
                type: 'string',
                format: 'password',
                example: 'NovaSenha@123'
            ),
            new OA\Property(
                property: 'password_confirmation',
                type: 'string',
                format: 'password',
                example: 'NovaSenha@123'
            ),
        ],
        type: 'object'
    )]
    public function rules()
    {
        return [
            'old_password' => ['required', 'string', 'current_password'],
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',              // must be at least 8 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ]
        ];
    }
}
