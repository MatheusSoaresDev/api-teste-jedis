<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class ModelNotFoundException extends Exception
{
    private string $model;

    public function __construct(string $model, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $this->model = $model;
        parent::__construct($message, $code, $previous);
    }

    public function render($request): JsonResponse
    {
        return response()->json([
            'code' => 404,
            'status' => 'error',
            'message' => ucfirst($this->model).' não encontrado!',
        ], 404);
    }
}
