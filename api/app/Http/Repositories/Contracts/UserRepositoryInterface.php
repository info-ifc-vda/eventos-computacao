<?php

namespace App\Http\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function findOrFail($userId): User;
    public function findByEmail($email): ?User;
}