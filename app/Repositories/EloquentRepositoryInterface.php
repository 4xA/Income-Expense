<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    public function createOrUpdate(array $data): Model;

    public function fill(array $data): Model;

    public function getAll(): Collection;

    public function getById($id): ?Model;

    public function delete($id): bool;

    public function paginate(array $data): Collection;

    public function firstWhere($column, $value): ?Model;

    public function whereNotIn($column, array $array): ?Model;
}
