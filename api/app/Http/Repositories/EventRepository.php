<?php

namespace App\Http\Repositories;

use App\Http\DTO\StoreEventParticipantDTO;
use App\Http\Repositories\Contracts\EventRepositoryInterface;
use App\Http\Requests\Organizers\CancelEventRequest;
use App\Http\Requests\Organizers\StoreEventRequest;
use App\Http\Requests\Organizers\UpdateEventRequest;
use App\Models\Event;
use App\Models\User;
use App\Models\EventExpense;
use App\Models\EventExpenseItem;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EventRepository implements EventRepositoryInterface
{
    public function getAll(Request $request): LengthAwarePaginator
    {
        return Event::paginate($request->query('per_page'));
    }

    public function store(StoreEventRequest $request): Event
    {
        $event = new Event();

        // TODO: Criar evento

        return $event->refresh();
    }

    public function find(string $eventId): Event
    {
        return Event::find($eventId);
    }

    public function findOrFail(string $eventId): Event
    {
        return Event::findOrFail($eventId);
    }

    public function update(string $eventId, UpdateEventRequest $request)
    {
        $event = $this->findOrFail($eventId);

        // TODO: Atualizar envento

        return $event;
    }

    public function cancel(string $eventId, CancelEventRequest $request)
    {
        $event = $this->findOrFail($eventId);

        // TODO: Cancelar evento

        return $event;
    }

    public function indexParticipants(string $eventId, Request $request)
    {
        return $this->findOrFail($eventId)->participants()->paginate($request->query('per_page'));
    }

    public function addParticipant(string $eventId, StoreEventParticipantDTO $dto)
    {
        $event = $this->findOrFail($eventId);

        // TODO: Adicionar participante ao evento

        return $event;
    }

    public function indexOrganizers(string $eventId, Request $request)
    {
        // TODO: Listar organizadores do evento
    }

    public function addOrganizer(string $eventId, User $user)
    {
        // TODO: Adicionar organizador ao evento
    }

    public function removeOrganizer(string $eventId, string $organizerId)
    {
        // TODO: Remover organizador do evento
    }

    // Métodos para despesas
    public function getEventExpenses(string $eventId, int $perPage = 15): LengthAwarePaginator
    {
        return EventExpense::where('event_id', $eventId)
            ->with(['user', 'items'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function createEventExpense(string $eventId, array $data): EventExpense
    {
        return DB::transaction(function () use ($eventId, $data) {
            // Criar a despesa
            $expense = EventExpense::create([
                'event_id' => $eventId,
                'user_id' => auth()->id(),
                'proof_access_key' => $data['proof_access_key'],
                'items_total' => 0, // Será calculado após criar os itens
            ]);

            // Criar os itens da despesa
            $totalValue = 0;
            foreach ($data['items'] as $itemData) {
                $discount = $itemData['discount'] ?? 0;
                $itemTotal = ($itemData['unit_value'] * $itemData['quantity']) - $discount;
                
                EventExpenseItem::create([
                    'event_expense_id' => $expense->id,
                    'description' => $itemData['description'],
                    'unit_value' => $itemData['unit_value'],
                    'quantity' => $itemData['quantity'],
                    'discount' => $discount,
                    'total_value' => $itemTotal,
                ]);
                
                $totalValue += $itemTotal;
            }

            // Atualizar o valor total da despesa
            $expense->update(['items_total' => $totalValue]);

            // Carregar os relacionamentos para retorno
            return $expense->load('items');
        });
    }

    public function findEventExpense(string $eventId, string $expenseId): ?EventExpense
    {
        return EventExpense::where('event_id', $eventId)
            ->where('uuid', $expenseId)
            ->with(['user', 'items'])
            ->first();
    }

    public function getUserEventExpenses(string $eventId, string $userId): Collection
    {
        return EventExpense::where('event_id', $eventId)
            ->where('user_id', $userId)
            ->with('items')
            ->get();
    }

    // TODO: Registrar chegada do participante ao evento (leitura do QR Code)
}