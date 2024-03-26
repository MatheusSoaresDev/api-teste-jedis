<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\Exceptions\MissingScopeException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'code' => 400,
                'message' => $e->errors()
            ], 400);
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ThrottleRequestsException) {
            return response()->json([
                'message' => 'Você atingiu o limite de requisições.',
                'status' => 'error',
                'code' => 429
            ], 429);
        }

        if ($e instanceof AuthenticationException) {
            return response()->json([
                'message' => 'Você não está autenticado.',
                'status' => 'error',
                'code' => 401
            ], 401);
        }

        if ($e instanceof MissingScopeException) {
            return response()->json([
                'message' => 'Você não tem permissão para acessar este recurso.',
                'status' => 'error',
                'code' => 403
            ], 403);
        }
        return parent::render($request, $e);
    }
}
