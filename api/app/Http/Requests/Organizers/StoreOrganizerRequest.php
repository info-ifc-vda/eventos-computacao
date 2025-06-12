<?php

namespace App\Http\Requests\Organizers;

use App\Http\Repositories\Contracts\EventRepositoryInterface;
use App\Http\Repositories\EventRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

class StoreOrganizerRequest extends FormRequest
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
        schema: 'OrganizersStoreOrganizerRequest',
        type: 'object',
        required: ['user_id'],
        properties: [
            new OA\Property(
                property: 'user_id',
                type: 'string',
                format: 'uuid',
                example: 'a1b2c3d4-e5f6-7g8h-9i0j-k1l2m3n4o5p6'
            ),
        ]
    )]
    public function rules()
    {
        return [
            'user_id' => ['required', 'exists:users,uuid'],
        ];
    }

}
