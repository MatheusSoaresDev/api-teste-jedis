<?php

namespace App\Repositories\Core\Eloquent;

use App\Enum\RoleEnum;
use App\Models\Produto;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Contracts\ProdutoRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserEloquentRepository extends BaseEloquentRepository implements UserRepositoryInterface
{
    public function entity(): string
    {
        return User::class;
    }

    public function getUserWithRoleByEmail(string $email): User
    {
        return $this->entity->whereEmail($email)->with('role')->firstOrFail();
    }

    public function promoteToAdmin(string $id): bool
    {
        $user = $this->findById($id);
        $user->role = Role::whereRole(RoleEnum::ADMIN->value)->first()->role;

        return $user->save();
    }

    public function realizaCompra(Produto $produto): User
    {
        $user = auth()->user();
        $user->compras()->attach($produto);

        return $user;
    }

    public function listaCompras(): array
    {
        $user = auth()->user();
        $compras = $user->compras()->get();

        $data = [];

        foreach ($compras as $compra) {
            $data[] = [
                'nome' => $compra->nome,
                'descricao' => $compra->descricao,
                'preco' => $compra->preco,
                'quantidade' => $compra->quantidade,
            ];
        }
        return $data;
    }

    public function listaCompra(string $id): array
    {
        $user = auth()->user();
        $compras = $user->compras()->where('produto_id', $id)->first();

        return [
            'nome' => $compras->nome,
            'descricao' => $compras->descricao,
            'preco' => $compras->preco,
            'quantidade' => $compras->quantidade,
        ];
    }
}
