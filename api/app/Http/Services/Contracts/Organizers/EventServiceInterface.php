<?php

namespace App\Http\Services\Contracts\Organizers;

use App\Http\Requests\Organizers\CancelEventRequest;
use App\Http\Requests\Organizers\StoreEventRequest;
use App\Http\Requests\Organizers\StoreOrganizerRequest;
use App\Http\Requests\Organizers\StoreParticipantArrivalRequest;
use App\Http\Requests\Organizers\UpdateEventRequest;
use App\Http\Resources\Organizers\EventParticipantArrivalResource;
use App\Http\Resources\Organizers\EventParticipantSummaryResource;
use App\Http\Resources\Organizers\EventResource;
use App\Http\Requests\Users\StoreParticipantRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface EventServiceInterface
{
    public function index(Request $request): AnonymousResourceCollection;
    public function store(StoreEventRequest $request): EventResource;
    public function show(Request $request): EventResource;
    public function update(UpdateEventRequest $request);
    public function cancel(CancelEventRequest $request);
    public function storeParticipantArrival(StoreParticipantArrivalRequest $request): EventParticipantArrivalResource;
    public function indexParticipants(Request $request): AnonymousResourceCollection;
    public function storeParticipant(StoreParticipantRequest $request): EventParticipantSummaryResource;
    public function indexOrganizers(Request $request);
    public function storeOrganizer(StoreOrganizerRequest $request);
    public function deleteOrganizer(Request $request);
}