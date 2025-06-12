<?php

namespace App\Http\Controllers;

use App\Http\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\ForgotUserRequest;
use App\Http\Requests\RecoveryUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserPassword;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserSummaryResource;
use DateTime;
use DateTimeZone;
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

    //! DEV: FUNCTION TO TEST SOME LARAVEL FUNCTIONS
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

    // TODO: Documentação
    public function forgot(ForgotUserRequest $request) {
        $user = $this->userRepository->findByEmailOrFail($request->get('email'));

        $date = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
        $token = Hash::make($request->get('email'));
    
        $user->recovery_account_token = $token;
        $user->recovery_account_token_created_at = $date;

        // TODO: send email
        $user->save();
        return response()->json(['message' => 'Se uma conta atrelada a este email existir será enviado um link para redefinir'], 200);
    }

    // TODO: Documentação
    public function recovery(RecoveryUserRequest $request) {
        $user = $this->userRepository->findByEmailOrFail($request->get('email'));

        if ($request->get('token') != $user->recovery_account_token) {
            
            $date = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
            $old = $user->recovery_account_token_created_at;
            $diff = clone $old;
            $diff->modify('+5 minutes');

            if ($date <= $diff) {
                $user->pasword = Hash::make($request->get('password'));
                return response()->json(['message' => 'Conta atualizada com sucesso!'], 200);
            }
        }
        return response()->json(['message' => 'Token inválido!'], 400);
    }
}
