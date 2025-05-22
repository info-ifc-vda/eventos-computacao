<?php

namespace App\Http\Services\Organizers;

use App\Http\Repositories\Contracts\EventRepositoryInterface;
use App\Http\Repositories\EventRepository;
use App\Http\Requests\Organizers\CancelEventRequest;
use App\Http\Requests\Organizers\StoreEventRequest;
use App\Http\Requests\Organizers\UpdateEventRequest;
use App\Http\Resources\Organizers\EventParticipantSummaryResource;
use App\Http\Resources\Organizers\EventResource;
use App\Http\Resources\Organizers\EventSummaryResource;
use App\Http\Services\Contracts\Organizers\EventServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventService implements EventServiceInterface
{
    public EventRepository $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        return EventSummaryResource::collection($this->eventRepository->index($request));
    }

    public function store(StoreEventRequest $request): EventResource
    {
        return new EventResource($this->eventRepository->store($request));
    }

    public function show(Request $request): EventResource
    {
        return new EventResource($this->eventRepository->show($request->route('event_id')));
    }

    public function update(UpdateEventRequest $request)
    {
        return new EventResource($this->eventRepository->update($request->route('event_id'), $request));
    }

    public function cancel(CancelEventRequest $request)
    {
        return new EventResource($this->eventRepository->cancel($request->route('event_id'), $request));
    }

    public function indexParticipants(Request $request): AnonymousResourceCollection
    {
        return EventParticipantSummaryResource::collection($this->eventRepository->indexParticipants($request->route('event_id'), $request));
    }
}