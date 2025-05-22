<?php

namespace App\Http\Services\Contracts\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface EventServiceInterface
{
    public function join(Request $request): AnonymousResourceCollection;
}