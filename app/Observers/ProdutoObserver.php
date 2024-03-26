<?php

namespace App\Observers;

use App\Models\Produto;
use Ramsey\Uuid\Uuid;

class ProdutoObserver
{
    public function creating(Produto $produto): void
    {
        $produto->id = (string) Uuid::uuid4();
    }
}
