<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\DTO\StoreEventParticipantDTO;
use App\Http\Repositories\Contracts\EventRepositoryInterface;
use App\Http\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Repositories\EventRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\Users\StoreParticipantRequest;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public EventRepository $eventRepository;
    public UserRepository $userRepository;

    public function __construct(EventRepositoryInterface $eventRepository, UserRepositoryInterface $userRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->userRepository = $userRepository;
    }

    public function join(StoreParticipantRequest $request)
    {
        $this->eventRepository->addParticipant(
            $request->get('event_id'),
            new StoreEventParticipantDTO(
                $this->userRepository->findOrFail(
                    $request->get('user_id')
                )
            )
        );
    }
}
