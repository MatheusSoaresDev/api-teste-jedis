<?php

namespace App\Repositories\Core\Eloquent;

use App\Enum\RoleEnum;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserEloquentRepository extends BaseEloquentRepository implements UserRepositoryInterface
{
    public function entity(): string
    {
        return User::class;
    }

    public function getUserWithRoleByEmail(string $email): User
    {
        return $this->entity->whereEmail($email)->with('role')->first();
    }

    public function promoteToAdmin(string $id): bool
    {
        $user = $this->findById($id);
        $user->role = Role::whereRole(RoleEnum::ADMIN->value)->first()->role;

        return $user->save();
    }
}
