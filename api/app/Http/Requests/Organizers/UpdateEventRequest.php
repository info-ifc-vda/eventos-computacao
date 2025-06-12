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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'OrganizersUpdateEventRequest',
        type: 'object',
        required: ['title', 'description', 'subscription_deadline', 'event_periods', 'location', 'bank_details'],
        properties: [
            new OA\Property(property: 'title', type: 'string', example: 'Evento Acadêmico 2025'),
            new OA\Property(property: 'description', type: 'string', example: 'Um evento sobre tecnologia e inovação.'),
            new OA\Property(property: 'subscription_deadline', type: 'string', format: 'date', example: '2025-06-20'),
            new OA\Property(property: 'payment_deadline', type: 'string', format: 'date', nullable: true, example: '2025-06-22'),
            new OA\Property(
                property: 'banner',
                type: 'object',
                properties: [
                    new OA\Property(property: 'data', type: 'string', nullable: true, example: 'base64string...'),
                    new OA\Property(property: 'url', type: 'string', nullable: true, example: 'https://example.com/banner.png')
                ]
            ),
            new OA\Property(property: 'estimated_value', type: 'number', nullable: true, example: 2500.50),
            new OA\Property(
                property: 'event_periods',
                type: 'array',
                items: new OA\Items(
                    type: 'object',
                    required: ['date', 'opening_time', 'closing_time'],
                    properties: [
                        new OA\Property(property: 'date', type: 'string', format: 'date', example: '2025-07-01'),
                        new OA\Property(property: 'opening_time', type: 'string', format: 'time', example: '08:00:00'),
                        new OA\Property(property: 'closing_time', type: 'string', format: 'time', example: '18:00:00')
                    ]
                )
            ),
            new OA\Property(
                property: 'location',
                type: 'object',
                required: ['address', 'maps_link'],
                properties: [
                    new OA\Property(
                        property: 'address',
                        type: 'object',
                        required: ['state', 'city', 'neighborhood', 'zip_code', 'street', 'number', 'complement'],
                        properties: [
                            new OA\Property(property: 'state', type: 'string', maxLength: 2, example: 'SP'),
                            new OA\Property(property: 'city', type: 'string', example: 'São Paulo'),
                            new OA\Property(property: 'neighborhood', type: 'string', example: 'Centro'),
                            new OA\Property(property: 'zip_code', type: 'string', example: '01000-000'),
                            new OA\Property(property: 'street', type: 'string', example: 'Av. Paulista'),
                            new OA\Property(property: 'number', type: 'string', example: '1000'),
                            new OA\Property(property: 'complement', type: 'string', example: 'Sala 201'),
                        ]
                    ),
                    new OA\Property(property: 'maps_link', type: 'string', example: 'https://goo.gl/maps/xyz')
                ]
            ),
            new OA\Property(
                property: 'bank_details',
                type: 'object',
                required: ['bank', 'holder', 'pix_key'],
                properties: [
                    new OA\Property(property: 'bank', type: 'string', example: 'Banco do Brasil'),
                    new OA\Property(property: 'holder', type: 'string', example: 'João da Silva'),
                    new OA\Property(property: 'pix_key', type: 'string', example: 'joao@email.com')
                ]
            )
        ]
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
            'location.maps_link' =>             ['required', 'string'],
            'bank_details.bank' =>              ['required', 'string'],
            'bank_details.holder' =>            ['required', 'string'],
            'bank_details.pix_key' =>           ['required', 'string']
        ];
    }
}
