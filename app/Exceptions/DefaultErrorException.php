<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class DefaultErrorException extends Exception
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'code' => 400,
            'status' => 'error',
            'message' => 'Houve um erro. Tente novamente mais tarde!',
        ], 400);
    }
}
