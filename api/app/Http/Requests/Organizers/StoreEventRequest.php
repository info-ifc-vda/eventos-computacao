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
    public function rules()
    {
        return [
            'title' =>                          ['required', 'string', 'max:255'],
            'description' =>                    ['required', 'string'],
            'subscription_deadline' =>          ['required', 'date'],
            'payment_deadline' =>               ['date'],
            'banner.data' =>                    ['present', 'nullable', 'string'],
            'estimated_value' =>                ['nullable', 'decimal:2'],
            'public_event' =>                   ['required', 'boolean'],
            'event_periods.*.date' =>           ['required', 'date_format:Y-m-d', /* Criar regra para validar se data é maior que hoje */],
            'event_periods.*.opening_time' =>   ['required', 'date_format:H:i:s', 'lt:event_periods.*.closing_time'],
            'event_periods.*.opening_time' =>   ['required', 'date_format:H:i:s', 'gt:event_periods.*.opening_time'],
        ];
    }
}
