<?php

namespace App\Http\DTO;

use App\Http\Requests\Users\StoreParticipantRequest as UsersStoreParticipantRequest;
use App\Models\User;

class StoreEventParticipantDTO
{
    public string $userId;

    public function __construct(User $user)
    {
        $this->userId = $user->id;
    }
}