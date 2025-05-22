<?php

namespace App\Http\Repositories;

use App\Http\DTO\StoreEventParticipantDTO;
use App\Http\Repositories\Contracts\EventRepositoryInterface;
use App\Http\Requests\Organizers\CancelEventRequest;
use App\Http\Requests\Organizers\StoreEventRequest;
use App\Http\Requests\Organizers\UpdateEventRequest;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class EventRepository implements EventRepositoryInterface
{
    public function getAll(Request $request): Collection
    {
        return Event::all()->paginate($request->query('per_page'));
    }

    public function store(StoreEventRequest $request): Event
    {
        $event = new Event();

        // Fazer aqui

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

        // Fazer aqui

        return $event;
    }

    public function cancel(string $eventId, CancelEventRequest $request)
    {
        $event = $this->findOrFail($eventId);

        // Fazer aqui

        return $event;
    }

    public function addParticipant(string $eventId, StoreEventParticipantDTO $dto)
    {
        $event = $this->findOrFail($eventId);

        // Fazer aqui

        return $event;
    }

    public function addOrganizer(string $eventId, User $user)
    {

    }
}