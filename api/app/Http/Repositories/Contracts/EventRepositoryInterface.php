<?php

namespace App\Http\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface EventRepositoryInterface
{
    public function index(Request $request): Collection;
}