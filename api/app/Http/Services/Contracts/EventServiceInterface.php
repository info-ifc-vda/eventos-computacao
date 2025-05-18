<?php

namespace App\Http\Services\Contracts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface EventServiceInterface
{
    public function index(Request $request): AnonymousResourceCollection;
}