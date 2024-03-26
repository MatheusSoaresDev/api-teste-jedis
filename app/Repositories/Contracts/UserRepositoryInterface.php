<?php

namespace App\Repositories\Contracts;

use App\Models\Produto;

interface UserRepositoryInterface
{
    public function promoteToAdmin(string $id):bool;
    public function realizaCompra(Produto $produto);
    public function listaCompras(): array;
    public function listaCompra(string $id): array;
}
