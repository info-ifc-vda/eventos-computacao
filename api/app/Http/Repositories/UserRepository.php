<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function findOrFail($userId): User
    {
        return User::findOrFail($userId);
    }

    public function findByEmail($email): ?User
    {
        return User::where('email', $email)->first();
    }
}