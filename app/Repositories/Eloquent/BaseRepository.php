<?php

namespace App\Repositories\Eloquent;

use App\Repositories\EloquentRepositoryInterface;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function createOrUpdate(array $data, $id = null): ?Model
    {
        $model = new $this->model;

        if (isset($id)) {
            $model = $this->getById($id);
        }

        if (is_null($model)) {
            return null;
        }

        $model->fill($data);

        $model->save();

        return $model;
    }

    public function fill($data): Model
    {
        return $this->model->fill($data);
    }

    public function getAll(): Collection
    {
        return $this->model->get();
    }

    public function chunk(int $size, Closure $callback): void
    {
        $this->model->chunk($size, $callback);
    }

    public function getById($id): ?Model
    {
        return $this->model->firstWhere('id', $id);
    }

    public function delete($id): bool
    {
        $model = $this->getById($id);

        if (is_null($model)) {
            return false;
        }

        return $model->delete();
    }

    public function paginate($data)
    {
        return $this->model->paginate($data['per_page']);
    }

    public function firstWhere($column, $value): ?Model
    {
        return $this->model->firstWhere($column, $value);
    }

    public function whereNotIn($column, array $array): ?Model
    {
        return $this->model->whereNotIn($column, $array)->get();
    }
}
