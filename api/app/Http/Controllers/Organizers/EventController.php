<?php

namespace App\Http\Controllers\Organizers;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\EventRepositoryInterface;
use App\Http\Repositories\EventRepository;
use App\Http\Requests\Organizers\CancelEventRequest;
use App\Http\Requests\Organizers\DeleteOrganizerRequest;
use App\Http\Requests\Organizers\StoreEventRequest;
use App\Http\Requests\Organizers\StoreOrganizerRequest;
use App\Http\Requests\Organizers\StoreParticipantArrivalRequest;
use App\Http\Requests\Organizers\UpdateEventRequest;
use App\Http\Requests\Users\StoreParticipantRequest;
use App\Http\Resources\Organizers\EventResource;
use App\Http\Resources\Organizers\EventSummaryResource;
use App\Http\Services\Contracts\Organizers\EventServiceInterface;
use App\Http\Services\Organizers\EventService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

use App\Http\Requests\StoreEventExpenseRequest;
use App\Http\Requests\UpdateEventExpenseRequest;
use App\Http\Resources\Organizers\EventExpenseResource;
use App\Http\Resources\Organizers\EventExpenseSummaryResource;
use App\Http\Resources\Organizers\EventOrganizerResource;
use App\Http\Resources\Organizers\EventOrganizerSummaryResource;
use App\Http\Resources\Organizers\EventParticipantArrivalResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;


class EventController extends Controller
{
    public EventRepository $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    #[OA\Get(
        path: '/api/v1/events',
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
                        )
                    ]
                )
            )
        ]
    )]
    public function index(Request $request)
    {
        // listar todos os dados do evento e suas tabelas relacionadas
        return EventResource::collection(
            $this->eventRepository->getAll($request)
        );
        // return EventSummaryResource::collection($this->eventRepository->getAll($request));
    }

    #[OA\Post(
        path: '/api/v1/events',
        tags: ['Events'],
        operationId: 'Events@store',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/OrganizersStoreEvent')
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Evento criado com sucesso',
                // content: new OA\JsonContent(ref: '#/components/schemas/OrganizersEvent')
            )
        ]
    )]
    public function store(StoreEventRequest $request)
    {
        return new EventResource($this->eventRepository->store($request));
    }

    public function show(Request $request)
    {
        return new EventResource($this->eventRepository->findOrFail($request->route('event_id')));
    }

    public function update(UpdateEventRequest $request)
    {
        return new EventResource($this->eventRepository->update($request->route('event_id'), $request));
    }

    public function cancel(CancelEventRequest $request)
    {
        return new EventResource($this->eventRepository->cancel($request->route('event_id'), $request));
    }

    public function indexParticipants(Request $request)
    {
        return EventParticipantArrivalResource::collection($this->eventRepository->indexParticipants($request->route('event_id'), $request));
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
        return EventOrganizerSummaryResource::collection($this->eventRepository->indexOrganizers($this->eventRepository->findOrFail($request->route('event_id'))->id, $request));
    }

    public function storeOrganizer(StoreOrganizerRequest $request)
    {
        return new EventOrganizerResource($this->eventRepository->storeOrganizer($this->eventRepository->findOrFail($request->route('event_id'))->id, $request));
    }

    public function deleteOrganizer(DeleteOrganizerRequest $request)
    {
        if ($this->eventRepository->deleteOrganizer($this->eventRepository->findOrFail($request->route('event_id'))->id, $request->route('organizer_id'))){
            return response()->json([], 204);
        }
    }

    /**
     * Lista todas as despesas de um evento
     */
    public function indexExpenses(Request $request)
    {
        \Log::info('Fetching expenses for event ID: ' . $request->route('event_id'));
        return EventExpenseSummaryResource::collection($this->eventRepository->getAllExpenses($this->eventRepository->findOrFail($request->route('event_id'))->id, $request));
    }

    //Métodos para despesas de eventos
    /**
     * Registra uma nova despesa para o evento
     */
    public function storeExpense(StoreEventExpenseRequest $request)
    {
        return new EventExpenseResource($this->eventRepository->storeExpense($this->eventRepository->findOrFail($request->route('event_id'))->id, $request));
    }

    /**
     * Exibe uma despesa específica
     */
    public function showExpense(Request $request)
    {
        return new EventExpenseResource($this->eventRepository->findEventExpenseOrFail($this->eventRepository->findOrFail($request->route('event_id'))->id, $request->route('event_expense_id')));
    }

    public function updateExpense(UpdateEventExpenseRequest $request)
    {
        $event = $this->eventRepository->findOrFail($request->route('event_id'));

        return new EventExpenseResource($this->eventRepository->updateExpense($event->id, $request->route('event_expense_id'), $request));
    }

    public function deleteExpense(Request $request)
    {
        \Log::info('Deleting expense for event ID: ' . $request->route('event_id') . ' and expense ID: ' . $request->route('event_expense_id'));
        $event = $this->eventRepository->findOrFail($request->route('event_id'));

        if ($this->eventRepository->deleteExpense($event->id, $request->route('event_expense_id'))) {
            return response()->json([], 204);
        }
    }

    public function leave(Request $request)
    {
        try{
            $this->eventRepository->leaveEvent($request->route('event_id'), $request->user()->id);
            return response()->json([], 204);
        } catch (\BadRequestException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

}
