<?php

namespace App\Http\Services\Users;

use App\Http\Repositories\Contracts\EventRepositoryInterface;
use App\Http\Repositories\EventRepository;
use App\Http\Services\Contracts\Users\EventServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventService implements EventServiceInterface
{
    public EventRepository $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function join(Request $request): AnonymousResourceCollection
    {
        return $this->eventRepository->addParticipant($request->route('event_id'), $this->userRepository->find());
    }
}