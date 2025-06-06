<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserPassword;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserSummaryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public UserRepository $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    // TODO: Implementar essa funcao ainda
    public function showMe(Request $request) 
    {

    }

    public function show(Request $request, $user_id)
    {
        if ($user_id == 'me' ){
            $user = Auth::user();
        } else {
            $user = $this->userRepository->findOrFail($user_id);
        }
        return new UserResource($user);
    }

    // TODO: Documentação
    public function index(Request $request)
    {
        return UserSummaryResource::collection($this->userRepository->getAll($request));
    }

    // TODO: Documentação
    public function store(StoreUserRequest $request)
    {
        return new UserResource($this->userRepository->store($request));
    }

    // TODO: Documentação
    public function update(UpdateUserRequest $request, $user_uuid) {
        if ($user_uuid == 'me' ){
            $user = Auth::user();
        }
        return new UserResource($this->userRepository->update($request, $user));
    }

    // TODO: Documentação
    public function updatePassword(UpdateUserPassword $request) 
    {
        $user = Auth::user();
        return new UserResource($this->userRepository->updatePassword($request, $user));
    }

    // TODO: E-mail para recuperação de senha
}
