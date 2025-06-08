<?php

namespace App\Http\Requests\Organizers;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

class StoreParticipantArrivalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'OrganizersStoreParticipantArrivalRequest',
        type: 'object',
        description: 'Nenhum campo definido.'
    )]
    // TODO: Documentação
    public function rules()
    {
        return [
            'participant_id' => ['required', 'integer'],
        ];
    }
}
