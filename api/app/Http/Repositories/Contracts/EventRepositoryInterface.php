<?php

namespace App\Http\Repositories\Contracts;

use App\Http\DTO\StoreEventParticipantDTO;
use App\Http\Requests\Organizers\CancelEventRequest;
use App\Http\Requests\Organizers\StoreEventRequest;
use App\Http\Requests\Organizers\UpdateEventRequest;
use App\Http\Requests\StoreEventExpenseRequest;
use App\Http\Requests\Users\StoreParticipantRequest;
use App\Models\Event;
use App\Models\EventExpense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface EventRepositoryInterface
{
    public function getAll(Request $request): LengthAwarePaginator;
    public function store(StoreEventRequest $request): Event;
    public function find(string $eventId): Event;
    public function findOrFail(string $eventId);
    public function update(string $eventId, UpdateEventRequest $request);
    public function cancel(string $eventId, CancelEventRequest $request);

    public function indexParticipants(string $eventId, Request $request);
    public function addParticipant(string $eventId, int $internalUserId);

    public function indexOrganizers(int $internalEventId, Request $request);
    public function storeOrganizer(int $internalEventId, Request $request);
    public function deleteOrganizer(int $internalEventId, string $organizerId);

    public function getAllExpenses(int $internalEventId, Request $request): LengthAwarePaginator;
    public function storeExpense(int $internalEventId, StoreEventExpenseRequest $request): EventExpense;
    public function findEventExpenseOrFail(int $internalEventId, string $eventExpenseId): EventExpense;

     // Novos métodos para despesas
    // public function getEventExpenses(string $eventId, int $perPage = 15): LengthAwarePaginator;
    // public function createEventExpense(string $eventId, array $data): EventExpense;
    // public function findEventExpense(string $eventId, string $expenseId): ?EventExpense;
    // public function getUserEventExpenses(string $eventId, string $userId): Collection;
}
