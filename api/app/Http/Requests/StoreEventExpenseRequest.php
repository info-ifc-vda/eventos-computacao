<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ajuste conforme sua lógica de autorização
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'proof_access_key' => ['required', 'string', 'max:55'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.description' => ['required', 'string', 'max:255'],
            'items.*.unit_value' => ['required', 'numeric', 'min:0'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'items.*.discount' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'proof_access_key.required' => 'A chave de acesso do cupom é obrigatória.',
            'items.required' => 'É necessário informar pelo menos um item.',
            'items.min' => 'É necessário informar pelo menos um item.',
            'items.*.description.required' => 'A descrição do item é obrigatória.',
            'items.*.unit_value.required' => 'O valor unitário é obrigatório.',
            'items.*.unit_value.numeric' => 'O valor unitário deve ser um número.',
            'items.*.unit_value.min' => 'O valor unitário deve ser maior ou igual a zero.',
            'items.*.quantity.required' => 'A quantidade é obrigatória.',
            'items.*.quantity.numeric' => 'A quantidade deve ser um número.',
            'items.*.quantity.min' => 'A quantidade deve ser maior que zero.',
            'items.*.discount.numeric' => 'O desconto deve ser um número.',
            'items.*.discount.min' => 'O desconto deve ser maior ou igual a zero.',
        ];
    }
}