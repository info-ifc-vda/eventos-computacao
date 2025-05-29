<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserSummaryResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public UserRepository $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
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

    // TODO: Atualização do usuário
    // TODO: E-mail para recuperação de senha
}
