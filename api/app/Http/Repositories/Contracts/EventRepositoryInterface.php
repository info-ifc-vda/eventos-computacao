<?php

namespace App\Http\Repositories\Contracts;

use App\Http\DTO\StoreEventParticipantDTO;
use App\Http\Requests\Organizers\CancelEventRequest;
use App\Http\Requests\Organizers\StoreEventRequest;
use App\Http\Requests\Organizers\UpdateEventRequest;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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
}