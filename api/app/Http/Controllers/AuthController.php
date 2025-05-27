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

class AuthController extends Controller
{
    public TokenRepository $tokenRepository;
    public RefreshTokenRepository $refreshTokenRepository;

    public function __construct()
    {
        $this->tokenRepository = app(TokenRepository::class);
        $this->refreshTokenRepository = app(RefreshTokenRepository::class);
    }

    public function login(LoginRequest $request)
    {
        $client = Client::where('password_client', 1)->first();

        $http = Http::asForm()->post((env('APP_ENV') == 'production' ? 'https' : 'http') .'://auth.eventos/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'scope' => '*',
        ]);

        return response()->json($http->json(), $http->status());

    }

    public function refresh(RefreshTokenRequest $request)
    {
        $client = Client::where('password_client', 1)->first();

        $http = Http::asForm()->post((env('APP_ENV') == 'production' ? 'https' : 'http') .'://auth.eventos/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->get('refresh_token'),
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'scope' => '*',
        ]);

        return response()->json($http->json(), $http->status());
    }

    public function logout(LogoutRequest $request)
    {
        $tokenId = Auth::user()->token()->id;
        $this->tokenRepository->revokeAccessToken($tokenId);
        // Revoke all of the token's refresh tokens...

        $this->refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);

        return response('', 204);
    }
}
