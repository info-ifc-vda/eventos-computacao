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
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    public UserRepository $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[OA\Get(
        path: '/api/v1/users/me',
        tags: ['Users'],
        summary: 'Obter dados do usuário autenticado',
        description: 'Retorna os dados do usuário autenticado com base no token.',
        operationId: 'User@showMe',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Dados do usuário retornados com sucesso',
                content: new OA\JsonContent(ref: '#/components/schemas/User')
            ),
            new OA\Response(
                response: 401,
                description: 'Usuário não autenticado'
            )
        ]
    )]
    public function showMe(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Usuário não autenticado'], 401);
        }

        return new UserResource($user);
    }


    #[OA\Get(
        path: '/api/v1/users/{id}',
        tags: ['Users'],
        summary: 'Buscar um usuário',
        description: 'Retorna os dados de um usuário pelo UUID ou "me" para o usuário autenticado.',
        operationId: 'User@show',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string'),
                description: 'UUID do usuário ou "me"'
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Usuário encontrado',
                content: new OA\JsonContent(ref: '#/components/schemas/User')
            ),
            new OA\Response(
                response: 404,
                description: 'Usuário não encontrado'
            )
        ]
    )]
    public function show(Request $request, $user_id)
    {
        if ($user_id == 'me' ){
            $user = Auth::user();
        } else {
            $user = $this->userRepository->findOrFail($user_id);
        }
        return new UserResource($user);
    }

    #[OA\Get(
        path: '/api/v1/users',
        tags: ['Users'],
        summary: 'Listar usuários',
        description: 'Retorna uma lista resumida de usuários com paginação e filtros opcionais.',
        operationId: 'User@index',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'search', in: 'query', schema: new OA\Schema(type: 'string'), required: false),
            new OA\Parameter(name: 'limit', in: 'query', schema: new OA\Schema(type: 'integer'), required: false),
            new OA\Parameter(name: 'page', in: 'query', schema: new OA\Schema(type: 'integer'), required: false)
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Lista de usuários retornada com sucesso',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/UserSummary')
                        )
                    ]
                )
            )
        ]
    )]
    public function index(Request $request)
    {
        return UserSummaryResource::collection($this->userRepository->getAll($request));
    }

    #[OA\Post(
        path: '/api/v1/users',
        tags: ['Users'],
        summary: 'Criar um novo usuário',
        description: 'Cria um novo usuário no sistema.',
        operationId: 'User@store',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/UsersStore')
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Usuário criado com sucesso',
                content: new OA\JsonContent(ref: '#/components/schemas/User')
            ),
            new OA\Response(response: 422, description: 'Erro de validação')
        ]
    )]
    public function store(StoreUserRequest $request)
    {
        return new UserResource($this->userRepository->store($request));
    }

    #[OA\Put(
        path: '/api/v1/users/{id}',
        tags: ['Users'],
        summary: 'Atualizar usuário',
        description: 'Atualiza os dados de um usuário pelo UUID ou "me".',
        operationId: 'User@update',
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string'),
                description: 'UUID do usuário ou "me"'
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/UsersUpdate')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Usuário atualizado com sucesso',
                content: new OA\JsonContent(ref: '#/components/schemas/User')
            ),
            new OA\Response(response: 422, description: 'Erro de validação')
        ]
    )]
    public function update(UpdateUserRequest $request, $user_uuid) {
        if ($user_uuid == 'me' ){
            $user = Auth::user();
        }
        return new UserResource($this->userRepository->update($request, $user));
    }

    #[OA\Put(
        path: '/api/v1/users/password',
        tags: ['Users'],
        summary: 'Alterar senha do usuário autenticado',
        description: 'Atualiza a senha do usuário autenticado.',
        operationId: 'User@updatePassword',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/UsersUpdatePassword')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Senha atualizada com sucesso',
                content: new OA\JsonContent(ref: '#/components/schemas/User')
            ),
            new OA\Response(response: 422, description: 'Erro de validação')
        ]
    )]
    public function updatePassword(UpdateUserPassword $request)
    {
        $user = Auth::user();
        return new UserResource($this->userRepository->updatePassword($request, $user));
    }

    // TODO: E-mail para recuperação de senha
}
