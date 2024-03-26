<?php

namespace App\Observers;

use App\Models\Role;
use Ramsey\Uuid\Uuid;

class RoleObserver
{
    public function creating(Role $role): void
    {
        $role->id = (string) Uuid::uuid4();
    }
}
