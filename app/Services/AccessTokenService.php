<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class AccessTokenService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function generateAccessToken(Request $request): Response
    {
        $user = $this->userRepository->getUserWithRoleByEmail($request->username);

        $request->request->add([
            'client_id' => config('passport.password_client.id'),
            'client_secret' => config('passport.password_client.secret'),
            "grant_type" => config('passport.password_client.grant_type'),
            "scope" => [
                $user->role
            ]
        ]);

        $tokenRequest = Request::create(
            'oauth/token',
            'POST'
        );

        return Route::dispatch($tokenRequest);
    }

    public function revokeAccessToken(Request $request): bool
    {
        return $request->user()->token()->revoke();
    }
}
