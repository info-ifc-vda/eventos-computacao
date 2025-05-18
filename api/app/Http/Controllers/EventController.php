<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Services\Contracts\EventServiceInterface;
use App\Http\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public EventService $eventService;

    public function __construct(EventServiceInterface $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(Request $request)
    {
        return response()->json([
            'olá' => "mundo"
        ]);

        return $this->eventService->index($request);
    }

    public function store(EventRequest $request)
    {
        return response()->json($request->all());
        // dd($request->body());
    }

    public function show(Request $request)
    {

    }
}
