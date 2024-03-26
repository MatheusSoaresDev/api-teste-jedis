<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class UuidFormatInvalidException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render($request): JsonResponse
    {
        return response()->json([
            'code' => 500,
            'status' => 'error',
            'message' => 'O id informado não é válido!',
        ], 500);
    }
}
