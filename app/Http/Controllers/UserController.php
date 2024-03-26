<?php

namespace App\Http\Controllers;

use App\Exceptions\DefaultErrorException;
use App\Http\Requests\CreateUserRequest;
use App\Repositories\Contracts\ProdutoRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws DefaultErrorException
     * @throws \App\Exceptions\ModelNotFoundException
     */
    public function register(CreateUserRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $user = $this->userRepository->create($data);

            return response()->json($user, 201);
        } catch (UniqueConstraintViolationException $e) {
            throw new \App\Exceptions\ModelNotFoundException('Usuario');
        } catch (\Exception $e) {
            throw new DefaultErrorException();
        }
    }

    /**
     * @throws DefaultErrorException
     * @throws \App\Exceptions\ModelNotFoundException
     */
    public function promoteToAdmin(string $id): JsonResponse
    {
        try {
            $this->userRepository->promoteToAdmin($id);

            return response()->json([
                'message' => 'Usuário promovido para administrador com sucesso!',
                'role' => 'admin',
                'status' => 'success',
                'code' => 200
            ]);
        } catch (ModelNotFoundException $e) {
            throw new \App\Exceptions\ModelNotFoundException('Usuario');
        } catch (\Exception $e) {
            throw new DefaultErrorException();
        }
    }

    public function realizaCompra(string $idProduto): JsonResponse
    {
        try {
            $produto = app(ProdutoRepositoryInterface::class)->findById($idProduto);

            $this->userRepository->realizaCompra($produto);

            return response()->json([
                'message' => 'Compra realizada com sucesso!',
                'status' => 'success',
                'code' => 200
            ]);
        } catch (ModelNotFoundException $e) {
            throw new \App\Exceptions\ModelNotFoundException('Usuario');
        } catch (\Exception $e) {
            throw new DefaultErrorException();
        }
    }

    public function listaCompras(): JsonResponse
    {
        try {
            return response()->json([
                'message' => 'Compra realizada com sucesso!',
                'status' => 'success',
                'code' => 200,
                'data' => $this->userRepository->listaCompras(),
            ]);
        } catch (\Exception $e) {
            throw new DefaultErrorException();
        }
    }

    /**
     * @throws DefaultErrorException
     */
    public function listaCompra(string $id): JsonResponse
    {
        try {
            return response()->json([
                'message' => 'Compra realizada com sucesso!',
                'status' => 'success',
                'code' => 200,
                'data' => $this->userRepository->listaCompra($id),
            ]);
        } catch (\Exception $e) {
            throw new DefaultErrorException();
        }
    }
}
