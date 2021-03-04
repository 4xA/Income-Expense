<?php

namespace App\Repositories\Eloquent;

use App\Expense;
use App\Repositories\ExpenseRepositoryInterface;

class ExpenseRepository extends BaseRepository implements ExpenseRepositoryInterface
{
    protected $model;

    public function __construct(Expense $model)
    {
        $this->model = $model;
    }
}
