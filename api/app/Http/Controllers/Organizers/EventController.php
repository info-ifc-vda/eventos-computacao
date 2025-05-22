<?php

namespace App\Http\Controllers\Organizers;

use App\Http\Controllers\Controller;
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
    public EventService $eventService;

    public function __construct(EventServiceInterface $eventService)
    {
        $this->eventService = $eventService;
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
        return $this->eventService->index($request);
    }

    public function store(StoreEventRequest $request)
    {
        return $this->eventService->store($request);
    }

    public function show(Request $request)
    {
        return $this->eventService->show($request);
    }

    public function update(UpdateEventRequest $request)
    {
        return $this->eventService->update($request);
    }

    public function cancel(CancelEventRequest $request)
    {
        return $this->eventService->cancel($request);
    }

    public function indexParticipants(Request $request)
    {
        return $this->eventService->indexParticipants($request);
    }

    public function storeParticipant(StoreParticipantRequest $request)
    {

    }

    public function storeParticipantArrival(StoreParticipantArrivalRequest $request)
    {
        return $this->eventService->storeParticipantArrival($request);
    }

    public function indexOrganizers(Request $request)
    {
        return $this->eventService->indexOrganizers($request);
    }
}
