<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

class StoreUserRequest extends FormRequest
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
        schema: 'UsersStore',
        type: 'object',
        required: ['name', 'email', 'password', 'phone'],
        properties: [
            new OA\Property(
                property: 'name',
                type: 'string',
                example: 'João Silva'
            ),
            new OA\Property(
                property: 'email',
                type: 'string',
                format: 'email',
                example: 'joao.silva@email.com'
            ),
            new OA\Property(
                property: 'phone',
                type: 'string',
                example: '49912345678'
            ),
            new OA\Property(
                property: 'password',
                type: 'string',
                format: 'password',
                minLength: 8,
                description: 'Deve conter ao menos 8 caracteres, incluindo letra minúscula, número e caractere especial (@$!%*#?&)',
                example: 'Senha@12'
            )
        ]
    )]
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'phone' => ['required', 'string'],
            'password' => [
                'required',
                'string',
                'min:8',              // must be at least 8 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ]
        ];
    }
}
