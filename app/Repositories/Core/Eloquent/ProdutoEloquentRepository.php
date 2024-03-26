<?php

namespace App\Repositories\Core\Eloquent;

use App\Models\Produto;
use App\Repositories\Contracts\ProdutoRepositoryInterface;

class ProdutoEloquentRepository extends BaseEloquentRepository implements ProdutoRepositoryInterface
{
    public function entity(): string
    {
        return Produto::class;
    }
}
