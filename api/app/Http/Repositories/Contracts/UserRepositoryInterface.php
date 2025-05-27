<?php

namespace App\Http\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function getAll(Request $request): LengthAwarePaginator;
    public function findOrFail($userId): User;
    public function findByEmail($email): ?User;
    public function findByEmailOrFail($email): User;
}