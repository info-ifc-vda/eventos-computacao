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


#[OA\Schema(
    schema: 'PaginationLinks',
    type: 'object',
    properties: [
        new OA\Property(property: 'first', type: 'string', format: 'uri'),
        new OA\Property(property: 'last', type: 'string', format: 'uri'),
        new OA\Property(property: 'prev', type: 'string', format: 'uri', nullable: true),
        new OA\Property(property: 'next', type: 'string', format: 'uri', nullable: true),
    ]
)]

#[OA\Schema(
    schema: 'PaginationMeta',
    type: 'object',
    properties: [
        new OA\Property(property: 'current_page', type: 'integer', example: 1),
        new OA\Property(property: 'from', type: 'integer', example: 1),
        new OA\Property(property: 'last_page', type: 'integer', example: 5),
        new OA\Property(property: 'path', type: 'string', example: 'http://localhost/api/v1/events'),
        new OA\Property(property: 'per_page', type: 'integer', example: 10),
        new OA\Property(property: 'to', type: 'integer', example: 10),
        new OA\Property(property: 'total', type: 'integer', example: 50),
    ]
)]

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
                description: "Listagem paginada de eventos detalhados",
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: "#/components/schemas/OrganizersEventSummary")
                        ),
                        new OA\Property(
                            property: 'links',
                            ref: '#/components/schemas/PaginationLinks'
                        ),
                        new OA\Property(
                            property: 'meta',
                            ref: '#/components/schemas/PaginationMeta'
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
                content: new OA\JsonContent(ref: '#/components/schemas/OrganizersStoreEvent')
            )
        ]
    )]
    public function store(StoreEventRequest $request)
    {
        return new EventResource($this->eventRepository->store($request));
    }

    #[OA\Get(
        path: '/api/v1/events/{event_id}',
        tags: ['Events'],
        operationId: 'Events@show',
        parameters: [
            new OA\Parameter(
                name: 'event_id',
                in: 'path',
                required: true,
                description: 'UUID do evento',
                schema: new OA\Schema(type: 'string', format: 'uuid')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Detalhes do evento',
                content: new OA\JsonContent(ref: '#/components/schemas/OrganizersEventExpenseItem')
            ),
            new OA\Response(response: 404, description: 'Evento não encontrado')
        ]
    )]
    public function show(Request $request)
    {
        return new EventResource($this->eventRepository->findOrFail($request->route('event_id')));
    }

    #[OA\Put(
        path: '/api/v1/events/{event_id}',
        tags: ['Events'],
        operationId: 'Events@update',
        parameters: [
            new OA\Parameter(
                name: 'event_id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string', format: 'uuid')
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/OrganizersUpdateEventRequest')
        ),
        responses: [
            new OA\Response(response: 200, description: 'Evento atualizado com sucesso'),
            new OA\Response(response: 404, description: 'Evento não encontrado')
        ]
    )]
    public function update(UpdateEventRequest $request)
    {
        return new EventResource($this->eventRepository->update($request->route('event_id'), $request));
    }

    #[OA\Post(
        path: '/api/v1/events/{event_id}/cancel',
        tags: ['Events'],
        operationId: 'Events@cancel',
        parameters: [
            new OA\Parameter(
                name: 'event_id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string', format: 'uuid'),
                description: 'UUID do evento a ser cancelado'
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/OrganizersCancelEventRequest')
        ),
        responses: [
            new OA\Response(response: 200, description: 'Evento cancelado com sucesso'),
            new OA\Response(response: 404, description: 'Evento não encontrado')
        ]
    )]
    public function cancel(CancelEventRequest $request)
    {
        return new EventResource($this->eventRepository->cancel($request->route('event_id'), $request));
    }

    #[OA\Get(
        path: '/api/v1/events/{event_id}/participants',
        tags: ['Events'],
        operationId: 'Events@indexParticipants',
        parameters: [
            new OA\Parameter(
                name: 'event_id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string', format: 'uuid'),
                description: 'UUID do evento'
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Participantes do evento listados com sucesso',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/OrganizersEventParticipantArrival')
                )
            )
        ]
    )]
    public function indexParticipants(Request $request)
    {
        return EventParticipantArrivalResource::collection($this->eventRepository->indexParticipants($request->route('event_id'), $request));
    }

    // #[OA\Post(
    //     path: '/api/v1/events/{event_id}/participants',
    //     tags: ['Events'],
    //     operationId: 'Events@storeParticipant',
    //     parameters: [
    //         new OA\Parameter(
    //             name: 'event_id',
    //             in: 'path',
    //             required: true,
    //             schema: new OA\Schema(type: 'string', format: 'uuid'),
    //             description: 'UUID do evento'
    //         )
    //     ],
    //     requestBody: new OA\RequestBody(
    //         required: true,
    //         content: new OA\JsonContent(ref: '#/components/schemas/StoreParticipantRequest')
    //     ),
    //     responses: [
    //         new OA\Response(response: 201, description: 'Participante cadastrado com sucesso')
    //     ]
    // )]
    //TODO fazer documentacao
    public function storeParticipant(StoreParticipantRequest $request)
    {

    }

    // #[OA\Post(
    //     path: '/api/v1/events/{event_id}/participants/{participant_id}/arrival',
    //     tags: ['Events'],
    //     operationId: 'Events@storeParticipantArrival',
    //     parameters: [
    //         new OA\Parameter(name: 'event_id', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid')),
    //         new OA\Parameter(name: 'participant_id', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid'))
    //     ],
    //     requestBody: new OA\RequestBody(
    //         required: true,
    //         content: new OA\JsonContent(ref: '#/components/schemas/StoreParticipantArrivalRequest')
    //     ),
    //     responses: [
    //         new OA\Response(response: 200, description: 'Chegada registrada com sucesso')
    //     ]
    // )]
    //TODO fazer documentacao
    public function storeParticipantArrival(StoreParticipantArrivalRequest $request)
    {
        // return $this->eventService->storeParticipantArrival($request);
    }

    #[OA\Get(
        path: '/api/v1/events/{event_id}/organizers',
        tags: ['Events'],
        operationId: 'Events@indexOrganizers',
        parameters: [
            new OA\Parameter(
                name: 'event_id',
                in: 'path',
                required: true,
                description: 'UUID do evento',
                schema: new OA\Schema(type: 'string', format: 'uuid')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Lista de organizadores do evento',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/OrganizersEventOrganizerSummary')
                )
            )
        ]
    )]
    public function indexOrganizers(Request $request)
    {
        return EventOrganizerSummaryResource::collection($this->eventRepository->indexOrganizers($this->eventRepository->findOrFail($request->route('event_id'))->id, $request));
    }

    #[OA\Post(
        path: '/api/v1/events/{event_id}/organizers',
        tags: ['Events'],
        operationId: 'Events@storeOrganizer',
        summary: 'Adiciona um novo organizador ao evento',
        parameters: [
            new OA\Parameter(
                name: 'event_id',
                in: 'path',
                required: true,
                description: 'UUID do evento',
                schema: new OA\Schema(type: 'string', format: 'uuid')
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/OrganizersStoreEvent')
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Organizador criado com sucesso',
                content: new OA\JsonContent(ref: '#/components/schemas/OrganizersEventSummary')
            )
        ]
    )]
    public function storeOrganizer(StoreOrganizerRequest $request)
    {
        return new EventOrganizerResource($this->eventRepository->storeOrganizer($this->eventRepository->findOrFail($request->route('event_id'))->id, $request));
    }

    #[OA\Delete(
        path: '/api/v1/events/{event_id}/organizers/{organizer_id}',
        operationId: 'Events@deleteOrganizer',
        tags: ['Events'],
        summary: 'Remove um organizador de um evento',
        description: 'Remove o organizador especificado do evento. O organizador atual não pode remover a si mesmo.',
        parameters: [
            new OA\Parameter(
                name: 'event_id',
                in: 'path',
                required: true,
                description: 'UUID do evento',
                schema: new OA\Schema(type: 'string', format: 'uuid')
            ),
            new OA\Parameter(
                name: 'organizer_id',
                in: 'path',
                required: true,
                description: 'UUID do organizador a ser removido',
                schema: new OA\Schema(type: 'string', format: 'uuid')
            ),
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Organizador removido com sucesso (sem conteúdo)'
            ),
            new OA\Response(
                response: 403,
                description: 'Ação não permitida (tentativa de remover a si mesmo)'
            ),
            new OA\Response(
                response: 404,
                description: 'Evento ou organizador não encontrado'
            )
        ]
    )]
    public function deleteOrganizer(DeleteOrganizerRequest $request)
    {
        if ($this->eventRepository->deleteOrganizer($this->eventRepository->findOrFail($request->route('event_id'))->id, $request->route('organizer_id'))){
            return response()->json([], 204);
        }
    }

    /**
     * Lista todas as despesas de um evento
     */
/**
 * Lista todas as despesas de um evento
 */
    #[OA\Get(
        path: '/api/v1/events/{event_id}/expenses',
        tags: ['Events'],
        operationId: 'Events@indexExpenses',
        summary: 'Lista todas as despesas de um evento',
        parameters: [
            new OA\Parameter(
                name: 'event_id',
                in: 'path',
                required: true,
                description: 'UUID do evento',
                schema: new OA\Schema(type: 'string', format: 'uuid')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Lista de despesas do evento',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/OrganizersEventExpenseSummary')
                )
            ),
            new OA\Response(
                response: 404,
                description: 'Evento não encontrado'
            )
        ]
    )]
    public function indexExpenses(Request $request)
    {
        return EventExpenseSummaryResource::collection($this->eventRepository->getAllExpenses($this->eventRepository->findOrFail($request->route('event_id'))->id, $request));
    }

    //Métodos para despesas de eventos
    /**
     * Registra uma nova despesa para o evento
     */
    #[OA\Post(
        path: '/api/v1/events/{event_id}/expenses',
        tags: ['Events'],
        operationId: 'Events@storeExpense',
        summary: 'Cria uma nova despesa associada a um evento',
        parameters: [
            new OA\Parameter(
                name: 'event_id',
                in: 'path',
                required: true,
                description: 'UUID do evento',
                schema: new OA\Schema(type: 'string', format: 'uuid')
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            description: 'Dados da despesa a ser criada',
            content: new OA\JsonContent(ref: '#/components/schemas/StoreEventExpenseRequest')
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Despesa criada com sucesso',
                content: new OA\JsonContent(ref: '#/components/schemas/OrganizersEventExpense')
            ),
            new OA\Response(
                response: 422,
                description: 'Dados inválidos ou incompletos'
            )
        ]
    )]
    public function storeExpense(StoreEventExpenseRequest $request)
    {
        return new EventExpenseResource($this->eventRepository->storeExpense($this->eventRepository->findOrFail($request->route('event_id'))->id, $request));
    }

    /**
     * Exibe uma despesa específica
     */

    #[OA\Get(
        path: '/api/v1/events/{event_id}/expenses/{event_expense_id}',
        tags: ['Events'],
        operationId: 'Events@showExpense',
        summary: 'Retorna os detalhes de uma despesa do evento',
        parameters: [
            new OA\Parameter(
                name: 'event_id',
                in: 'path',
                required: true,
                description: 'UUID do evento',
                schema: new OA\Schema(type: 'string', format: 'uuid')
            ),
            new OA\Parameter(
                name: 'event_expense_id',
                in: 'path',
                required: true,
                description: 'UUID da despesa',
                schema: new OA\Schema(type: 'string', format: 'uuid')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Detalhes da despesa',
                content: new OA\JsonContent(ref: '#/components/schemas/OrganizersEventExpense')
            ),
            new OA\Response(
                response: 404,
                description: 'Despesa não encontrada'
            )
        ]
    )]
    public function showExpense(Request $request)
    {
        return new EventExpenseResource($this->eventRepository->findEventExpenseOrFail($this->eventRepository->findOrFail($request->route('event_id'))->id, $request->route('event_expense_id')));
    }

    /**
     * Atualiza uma despesa de um evento
     */
    #[OA\Put(
        path: '/api/v1/events/{event_id}/expenses/{event_expense_id}',
        tags: ['Events'],
        operationId: 'Events@updateExpense',
        summary: 'Atualiza os dados de uma despesa do evento',
        parameters: [
            new OA\Parameter(
                name: 'event_id',
                in: 'path',
                required: true,
                description: 'UUID do evento',
                schema: new OA\Schema(type: 'string', format: 'uuid')
            ),
            new OA\Parameter(
                name: 'event_expense_id',
                in: 'path',
                required: true,
                description: 'UUID da despesa do evento',
                schema: new OA\Schema(type: 'string', format: 'uuid')
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            description: 'Dados atualizados da despesa',
            content: new OA\JsonContent(ref: '#/components/schemas/StoreEventExpenseRequest') // ou um schema específico para atualização
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Despesa atualizada com sucesso',
                content: new OA\JsonContent(ref: '#/components/schemas/OrganizersEventExpense')
            ),
            new OA\Response(
                response: 404,
                description: 'Despesa não encontrada'
            )
        ]
    )]
    public function updateExpense(UpdateEventExpenseRequest $request)
    {
        $event = $this->eventRepository->findOrFail($request->route('event_id'));

        return new EventExpenseResource($this->eventRepository->updateExpense($event->id, $request->route('event_expense_id'), $request));
    }


    /**
     * Permite que o usuário saia do evento
     */
    #[OA\Post(
        path: '/api/v1/events/{event_id}/leave',
        tags: ['Events'],
        operationId: 'Events@leave',
        summary: 'Usuário sai do evento',
        parameters: [
            new OA\Parameter(
                name: 'event_id',
                in: 'path',
                required: true,
                description: 'UUID do evento',
                schema: new OA\Schema(type: 'string', format: 'uuid')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Usuário saiu do evento com sucesso, sem conteúdo na resposta'
            ),
            new OA\Response(
                response: 400,
                description: 'Requisição inválida',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'message', type: 'string', example: 'Mensagem de erro detalhada')
                    ]
                )
            )
        ]
    )]
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
