<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function getAll(Request $request): LengthAwarePaginator
    {
        return User::search($request->query('q'))->paginate($request->query('per_page'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = new User();

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        
        // código para remover a mascara do telefone
        // "(49) 91234-5678" 15 chars que contém '(', ')', ' ', '-' que devem ser removidos
        $user->phone = preg_replace('/\D/', '', $request->get('phone'));
        
        $user->password = Hash::make($request->get('password'));

        $user->save();

        return $user->refresh();
    }

    public function findOrFail($userId): User
    {
        return User::findOrFail($userId);
    }

    public function findByEmail($email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findByEmailOrFail($email): User
    {
        return User::where('email', $email)->firstOrFail();
    }
}