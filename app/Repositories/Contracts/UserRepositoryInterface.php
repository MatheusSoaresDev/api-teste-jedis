<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function promoteToAdmin(string $id);
    public function realizaCompra();
}
