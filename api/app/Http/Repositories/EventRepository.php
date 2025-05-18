<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\EventRepositoryInterface;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class EventRepository implements EventRepositoryInterface
{
    public function index(Request $request): Collection
    {
        return Event::all();
    }
}