<?php

namespace App\Http\Requests\Organizers;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

class UpdateEventRequest extends FormRequest
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
        schema: 'OrganizersUpdateEventRequest',
        type: 'object',
        description: 'Schema da requisição para atualização de evento. Ainda não definido.'
    )]
    public function rules()
    {
        return [
            'title' =>                          ['required', 'string', 'max:255'],
            'description' =>                    ['required', 'string'],
            'subscription_deadline' =>          ['required', 'date'],
            'payment_deadline' =>               ['date'],
            'banner.data' =>                    ['sometimes', 'required_without:banner.url', 'string'],
            'banner.url' =>                     ['sometimes', 'required_without:banner.data', 'string'],
            'estimated_value' =>                ['nullable', 'numeric'],
            // 'public_event' =>                   ['required', 'boolean'],
            'event_periods.*.date' =>           ['required', 'date_format:Y-m-d', /* Criar regra para validar se data é maior que hoje */],
            'event_periods.*.opening_time' =>   ['required', 'date_format:H:i:s'],
            'event_periods.*.closing_time' =>   ['required', 'date_format:H:i:s'],
            'location.address.state' =>         ['required', 'string', 'size:2'],
            'location.address.city' =>          ['required', 'string'],
            'location.address.neighborhood' =>  ['required', 'string'],
            'location.address.zip_code' =>      ['required', 'string', 'size:9'],
            'location.address.street' =>        ['required', 'string'],
            'location.address.number' =>        ['required', 'string'],
            'location.address.complement' =>    ['required', 'string'],
            // 'location.maps_link' =>             ['required', 'string'],
            'bank_details.bank' =>              ['required', 'string'],
            'bank_details.holder' =>            ['required', 'string'],
            'bank_details.pix_key' =>           ['required', 'string']
        ];
    }
}
