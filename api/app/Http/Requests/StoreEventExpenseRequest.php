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
            'title' => ['required', 'string'],
            'items_total' => ['required', 'numeric'],
            // 'items' => ['required', 'array', 'min:1'],
            // 'items.*.description' => ['required', 'string', 'max:255'],
            // 'items.*.unit_value' => ['required', 'numeric', 'min:0'],
            // 'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            // 'items.*.discount' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}