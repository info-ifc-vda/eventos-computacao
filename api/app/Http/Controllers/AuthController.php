<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Requests\RefreshTokenRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Client;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    public TokenRepository $tokenRepository;
    public RefreshTokenRepository $refreshTokenRepository;

    public function __construct()
    {
        $this->tokenRepository = app(TokenRepository::class);
        $this->refreshTokenRepository = app(RefreshTokenRepository::class);
    }

    #[OA\Post(
        path: '/api/v1/auth/login',
        tags: ['Auth'],
        summary: 'Autenticação do usuário',
        description: 'Gera um token de acesso com base nas credenciais do usuário.',
        operationId: 'Auth@login',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/AuthLoginRequest')
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Token gerado com sucesso',
                content: new OA\JsonContent(
                    type: 'object',
                    properties: [
                        new OA\Property(property: 'token_type', type: 'string', example: 'Bearer'),
                        new OA\Property(property: 'expires_in', type: 'integer', example: 31536000),
                        new OA\Property(property: 'access_token', type: 'string', example: 'eyJ0eXAiOiJKV1Qi...'),
                        new OA\Property(property: 'refresh_token', type: 'string', example: 'def50200acb123...')
                    ]
                )
            ),
        ]
    )]
    public function login(LoginRequest $request)
    {
        $client = Client::where('password_client', 1)->first();

        $http = Http::asForm()->post((env('APP_ENV') == 'production' ? 'http' : 'http') .'://reverse-proxy/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'scope' => '*',
        ]);

        return response()->json($http->json(), $http->status());

    }

    // TODO: Documentação
    public function refresh(RefreshTokenRequest $request)
    {
        $client = Client::where('password_client', 1)->first();

        $http = Http::asForm()->post((env('APP_ENV') == 'production' ? 'http' : 'http') .'://reverse-proxy/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->get('refresh_token'),
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'scope' => '*',
        ]);

        return response()->json($http->json(), $http->status());
    }

    #[OA\Get(
        path: '/api/v1/auth/logout',
        tags: ['Auth'],
        summary: 'desautenticação do usuário autenticado',
        description: 'Revoga o token de acesso atual e todos os tokens de atualização associados.',
        operationId: 'Auth@logout',
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Logout realizado com sucesso!',
                content: [
                    'application/json' => new OA\MediaType(
                        mediaType: 'application/json'
                    )
                ]
            )
        ]
    )]
    public function logout(LogoutRequest $request)
    {
        $tokenId = Auth::user()->token()->id;
        $this->tokenRepository->revokeAccessToken($tokenId);
        // Revoke all of the token's refresh tokens...

        $this->refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);

        return response('', 204);
    }
}
