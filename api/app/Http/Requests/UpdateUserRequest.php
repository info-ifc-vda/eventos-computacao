<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

class UpdateUserRequest extends FormRequest
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
        schema: 'UsersUpdate',
        required: ['name', 'phone'],
        properties: [
            new OA\Property(
                property: 'name',
                type: 'string',
                example: 'Maria da Silva'
            ),
            new OA\Property(
                property: 'phone',
                type: 'string',
                example: '49912345678'
            ),
        ],
        type: 'object'
    )]
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'phone' => ['required', 'string']
        ];
    }
}
