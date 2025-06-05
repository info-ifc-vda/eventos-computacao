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

use App\Http\Requests\StoreEventExpenseRequest;
use App\Http\Resources\EventExpenseResource;
use App\Http\Resources\EventExpenseSummaryResource;
use Illuminate\Http\JsonResponse;


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

    /**
     * Lista todas as despesas de um evento
     */
    public function indexExpenses(Request $request, string $eventId): JsonResponse
    {
        try {
            // Verificar se o evento existe
            $event = $this->eventRepository->find($eventId);
            if (!$event) {
                return response()->json([
                    'message' => 'Evento não encontrado.'
                ], 404);
            }

            $perPage = $request->get('per_page', 15);
            $expenses = $this->eventRepository->getEventExpenses($eventId, $perPage);

            return response()->json([
                'data' => EventExpenseSummaryResource::collection($expenses->items()),
                'meta' => [
                    'current_page' => $expenses->currentPage(),
                    'last_page' => $expenses->lastPage(),
                    'per_page' => $expenses->perPage(),
                    'total' => $expenses->total(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar despesas do evento.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //Métodos para despesas de eventos
    /**
     * Registra uma nova despesa para o evento
     */
    public function storeExpense(StoreEventExpenseRequest $request, string $eventId): JsonResponse
    {
        try {
            // Verificar se o evento existe
            $event = $this->eventRepository->find($eventId);
            if (!$event) {
                return response()->json([
                    'message' => 'Evento não encontrado.'
                ], 404);
            }

            $expense = $this->eventRepository->createEventExpense($eventId, $request->validated());

            return response()->json([
                'data' => new EventExpenseResource($expense),
                'message' => 'Despesa registrada com sucesso.'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao registrar despesa.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exibe uma despesa específica
     */
    public function showExpense(string $eventId, string $expenseUuid): JsonResponse
    {
        try {
            $expense = $this->eventRepository->findEventExpense($eventId, $expenseUuid);
            
            if (!$expense) {
                return response()->json([
                    'message' => 'Despesa não encontrada.'
                ], 404);
            }

            // Verificar se o usuário pode visualizar esta despesa
            // (pode ser o próprio usuário ou ter permissões especiais)
            if ($expense->user_id !== auth()->id() && !$this->canViewExpense($expense)) {
                return response()->json([
                    'message' => 'Não autorizado a visualizar esta despesa.'
                ], 403);
            }

            return response()->json([
                'data' => new EventExpenseResource($expense)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar despesa.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verifica se o usuário pode visualizar a despesa
     * Implemente conforme suas regras de negócio
     */
    private function canViewExpense($expense): bool
    {
        // Exemplo: apenas administradores ou organizadores do evento podem ver
        // Adapte conforme sua lógica de permissões
        return auth()->user()->hasRole('admin') || 
               auth()->user()->isEventOrganizer($expense->event_id);
    }
}
