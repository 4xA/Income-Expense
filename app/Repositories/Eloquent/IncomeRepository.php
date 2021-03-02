<?php

namespace App\Repositories\Eloquent;

use App\Income;
use App\Repositories\IncomeRepositoryInterface;

class IncomeRepository extends BaseRepository implements IncomeRepositoryInterface
{
    protected $model;

    public function __construct(Income $model)
    {
        $this->model = $model;
    }
}
