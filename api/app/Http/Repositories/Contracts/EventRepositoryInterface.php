<?php

namespace App\Http\Repositories\Contracts;

use App\Http\DTO\StoreEventParticipantDTO;
use App\Http\Requests\Organizers\CancelEventRequest;
use App\Http\Requests\Organizers\StoreEventRequest;
use App\Http\Requests\Organizers\UpdateEventRequest;
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
    public function addParticipant(string $eventId, StoreEventParticipantDTO $dto);

    public function indexOrganizers(string $eventId, Request $request);
    public function addOrganizer(string $eventId, User $user);
    public function removeOrganizer(string $eventId, string $organizerId);

    public function getAllExpenses(int $internalEventId, Request $request): LengthAwarePaginator;

     // Novos métodos para despesas
    public function getEventExpenses(string $eventId, int $perPage = 15): LengthAwarePaginator;
    public function createEventExpense(string $eventId, array $data): EventExpense;
    public function findEventExpense(string $eventId, string $expenseId): ?EventExpense;
    public function getUserEventExpenses(string $eventId, string $userId): Collection;
}