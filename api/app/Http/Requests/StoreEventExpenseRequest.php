<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

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
    #[OA\Schema(
        schema: "StoreEventExpenseRequest",
        type: "object",
        required: ["proof_access_key", "title", "items_total"],
        properties: [
            new OA\Property(
                property: "proof_access_key",
                type: "string",
                maxLength: 55,
                example: "abc123xyz456",
                description: "Chave de acesso para comprovação da despesa"
            ),
            new OA\Property(
                property: "title",
                type: "string",
                example: "Despesas com alimentação",
                description: "Título ou descrição resumida da despesa"
            ),
            new OA\Property(
                property: "items_total",
                type: "number",
                format: "float",
                example: 378.45,
                description: "Valor total dos itens da despesa"
            )
        ]
    )]
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