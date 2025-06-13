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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'OrganizersStoreParticipantArrivalRequest',
        type: 'object',
        description: 'Campos ainda não definidos. Atualize com os campos reais assim que possível.',
        properties: [
            // Exemplo:
            // new OA\Property(property: 'participant_id', type: 'string', format: 'uuid'),
        ]
    )]
    // TODO: Documentação
    public function rules()
    {
        return [
            //
        ];
    }
}
