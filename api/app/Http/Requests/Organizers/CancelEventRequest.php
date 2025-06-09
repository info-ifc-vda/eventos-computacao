<?php

namespace App\Http\Requests\Organizers;

use App\Http\Repositories\Contracts\EventRepositoryInterface;
use App\Http\Repositories\EventRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

class CancelEventRequest extends FormRequest
{
    public EventRepository $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        parent::__construct();
        $this->eventRepository = $eventRepository;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $event = $this->eventRepository->findOrFail($this->route('event_id'));
        $user = Auth::user();

        return $event
            && $user
            && $event->user_id === $user->id
            && $user->can('event_creator');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'OrganizersCancelEventRequest',
        type: 'object',
        required: ['cancellation_description'],
        properties: [
            new OA\Property(property: 'cancellation_description', type: 'string', example: 'Ninguém comprou os insumos'),
        ],
        description: 'Requisição para cancelar um evento.'
    )]

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'cancellation_description' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'cancellation_description.required' => 'A descrição do cancelamento é obrigatória.',
        ];
    }
}
