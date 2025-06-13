<?php

namespace App\Http\Requests\Organizers;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

class StoreEventRequest extends FormRequest
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
        schema: 'OrganizersStoreEventRequest',
        type: 'object',
        required: [
            'title',
            'description',
            'subscription_deadline',
            'public_event',
            'event_periods'
        ],
        properties: [
            new OA\Property(
                property: 'title',
                type: 'string',
                maxLength: 255,
                example: 'Festa de Inverno'
            ),
            new OA\Property(
                property: 'description',
                type: 'string',
                example: 'Evento anual aberto ao público com diversas atrações.'
            ),
            new OA\Property(
                property: 'subscription_deadline',
                type: 'string',
                format: 'date',
                example: '2025-07-01'
            ),
            new OA\Property(
                property: 'payment_deadline',
                type: 'string',
                format: 'date',
                nullable: true,
                example: '2025-07-10'
            ),
            new OA\Property(
                property: 'banner',
                type: 'object',
                nullable: true,
                properties: [
                    new OA\Property(
                        property: 'data',
                        type: 'string',
                        nullable: true,
                        example: 'base64encodedimage...'
                    )
                ]
            ),
            new OA\Property(
                property: 'estimated_value',
                type: 'number',
                format: 'float',
                nullable: true,
                example: 1500.75
            ),
            new OA\Property(
                property: 'public_event',
                type: 'boolean',
                example: true
            ),
            new OA\Property(
                property: 'event_periods',
                type: 'array',
                items: new OA\Items(
                    type: 'object',
                    required: ['date', 'opening_time', 'closing_time'],
                    properties: [
                        new OA\Property(
                            property: 'date',
                            type: 'string',
                            format: 'date',
                            example: '2025-08-01',
                            description: 'Data do evento (deve ser no futuro)'
                        ),
                        new OA\Property(
                            property: 'opening_time',
                            type: 'string',
                            format: 'time',
                            example: '18:00:00'
                        ),
                        new OA\Property(
                            property: 'closing_time',
                            type: 'string',
                            format: 'time',
                            example: '23:00:00'
                        )
                    ]
                )
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
            'banner.data' =>                    ['present', 'nullable', 'string'],
            'estimated_value' =>                ['nullable', 'numeric'],
            // 'public_event' =>                   ['required', 'boolean'],
            'event_periods.*.date' =>           ['required', 'date_format:Y-m-d'],
            'event_periods.*.opening_time' =>   ['required', 'date_format:H:i:s'],
            'event_periods.*.closing_time' =>   ['required', 'date_format:H:i:s'],
            'location.address.state' =>         ['required', 'string', 'size:2'],
            'location.address.city' =>          ['required', 'string'],
            'location.address.neighborhood' =>  ['required', 'string'],
            'location.address.zip_code' =>      ['required', 'string', 'size:9'],
            'location.address.street' =>        ['required', 'string'],
            'location.address.number' =>        ['required', 'string'],
            'location.address.complement' =>    ['required', 'string'],
            'location.maps_link' =>             ['required', 'string', 'active_url'],
            'bank_details.bank' =>              ['required', 'string'],
            'bank_details.holder' =>            ['required', 'string'],
            'bank_details.pix_key' =>           ['required', 'string']
        ];
    }
}
