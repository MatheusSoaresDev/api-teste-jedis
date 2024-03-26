<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\UniqueConstraintViolationException;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(CreateUserRequest $request)
    {
        try {
            $data = $request->validated();
            $user = $this->userRepository->create($data);

            return response()->json($user, 201);
        } catch (UniqueConstraintViolationException $e) {
            return response()->json(['message' => 'Usuário já cadastrado!'], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Houve um erro. Tente novamente mais tarde!'], 400);
        }
    }

    public function promoteToAdmin(string $id)
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
            return response()->json(['message' => 'Usuário não encontrado!'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Houve um erro. Tente novamente mais tarde!'], 400);
        }
    }
}
