<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AccessTokenService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AccessTokenController extends Controller
{
    private AccessTokenService $accessTokenService;

    public function __construct(AccessTokenService $accessTokenService)
    {
        $this->accessTokenService = $accessTokenService;
    }

    public function generateAccessToken(Request $request): mixed
    {
        try {
            return $this->accessTokenService->generateAccessToken($request);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Usuário não cadastrado.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao gerar token'], 500);
        }
    }

    public function revokeAccessToken(Request $request): JsonResponse
    {
        try {
            $this->accessTokenService->revokeAccessToken($request);
            return response()->json(['message' => 'Token revogado com sucesso']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao revogar token'], 500);
        }
    }
}
