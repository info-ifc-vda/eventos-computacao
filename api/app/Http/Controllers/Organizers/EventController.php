<?php

namespace App\Http\Controllers\Organizers;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\EventRepositoryInterface;
use App\Http\Repositories\EventRepository;
use App\Http\Requests\Organizers\CancelEventRequest;
use App\Http\Requests\Organizers\StoreEventRequest;
use App\Http\Requests\Organizers\StoreParticipantArrivalRequest;
use App\Http\Requests\Organizers\UpdateEventRequest;
use App\Http\Requests\Users\StoreParticipantRequest;
use App\Http\Services\Contracts\Organizers\EventServiceInterface;
use App\Http\Services\Organizers\EventService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class EventController extends Controller
{
    public EventRepository $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    #[OA\Get(
        path: '/events/index',
        tags: ['Events'],
        operationId: 'Events@index',
        parameters: [
            new OA\Parameter(ref: "#/components/parameters/per_page"),
            new OA\Parameter(ref: "#/components/parameters/page"),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Listagem com {per_page} registros",
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(
                                ref: "#/components/schemas/OrganizersEventSummary"
                            )
                        ),

                    ]
                )
            )
        ]
    )]
    public function index(Request $request)
    {
        return $this->eventRepository->getAll($request);
    }

    public function store(StoreEventRequest $request)
    {
        return $this->eventRepository->store($request);
    }

    public function show(Request $request)
    {
        return $this->eventRepository->findOrFail($request);
    }

    public function update(UpdateEventRequest $request)
    {
        return $this->eventRepository->update($request->route('event_id'), $request);
    }

    public function cancel(CancelEventRequest $request)
    {
        return $this->eventRepository->cancel($request->route('event_id'), $request);
    }

    public function indexParticipants(Request $request)
    {
        return $this->eventRepository->indexParticipants($request->route('event_id'), $request);
    }

    public function storeParticipant(StoreParticipantRequest $request)
    {

    }

    public function storeParticipantArrival(StoreParticipantArrivalRequest $request)
    {
        // return $this->eventService->storeParticipantArrival($request);
    }

    public function indexOrganizers(Request $request)
    {
        // return $this->eventService->indexOrganizers($request);
    }
}
