<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\DTO\StoreEventParticipantDTO;
use App\Http\Repositories\Contracts\EventRepositoryInterface;
use App\Http\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Repositories\EventRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\Users\StoreParticipantRequest;
use App\Http\Resources\Users\EventParticipantResource;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use App\Http\Resources\EventResource;

class EventController extends Controller
{
    public EventRepository $eventRepository;
    public UserRepository $userRepository;

    public function __construct(EventRepositoryInterface $eventRepository, UserRepositoryInterface $userRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $eventos = $this->eventRepository->allWithRelations();
        dd($eventos);
        return EventResource::collection($eventos);
    }

    // #[OA\Post(
    //     path: '/events/join',
    //     tags: ['Events'],
    //     operationId: 'Events@join',
    //     requestBody: new OA\RequestBody(
    //         content: new OA\JsonContent(
    //             ref: "#/components/schemas/UsersStoreParticipant"
    //         )
    //     ),
    //     responses: [
    //         new OA\Response(
    //             response: 200,
    //             description: "Listagem com {per_page} registros",
    //             content: new OA\JsonContent(
    //                 type: 'object',
    //                 properties: [
    //                     new OA\Property(
    //                         property: 'data',
    //                         type: 'array',
    //                         items: new OA\Items(
    //                             ref: "#/components/schemas/UsersEventParticipant"
    //                         )
    //                     ),
    //                 ]
    //             )
    //         )
    //     ]
    // )]
    public function join(StoreParticipantRequest $request)
    {
        return new EventParticipantResource($this->eventRepository->addParticipant(
            $request->get('event_id'),
            $this->userRepository->findOrFail($request->get('user_id'))->id
        ));
    }

    // função para verificar se o usuário já é participante do evento
    public function isParticipant(StoreParticipantRequest $request)
    {
        $event = $this->eventRepository->findOrFail($request->get('event_id'));
        $user = $this->userRepository->findOrFail($request->get('user_id'));

        $isParticipant = $event->participants()->where('user_id', $user->id)->exists();

        \Log::info('Checking if user is participant', [
            'event_id' => $event->id,
            'user_id' => $user->id,
            'is_participant' => $isParticipant
        ]);

        return response()->json(['is_participant' => $isParticipant]);
    }

}
