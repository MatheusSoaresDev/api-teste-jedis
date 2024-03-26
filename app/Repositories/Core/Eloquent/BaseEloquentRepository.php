<?php

namespace App\Repositories\Core\Eloquent;

use App\Repositories\Contracts\RepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class BaseEloquentRepository implements RepositoryInterface
{
    protected $entity;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->entity = $this->resolveEntity();
    }

    public function findAll()
    {
        return $this->entity->all();
    }

    public function create(array $data): Model
    {
        return $this->entity->create($data);
    }

    public function update(string $id, array $data): Model
    {
        $entity = $this->findById($id);
        $entity->update($data);

        return $entity;
    }

    public function delete(string $id): bool
    {
        return $this->findById($id)->delete();
    }

    public function findById(string $id): Model
    {
        return $this->entity->findOrFail($id);
    }

    /**
     * @throws Exception
     */
    public function resolveEntity(): Model
    {
        return ! method_exists($this, 'entity') ? throw new Exception('Entity Not Defined') : app($this->entity());
    }
}
