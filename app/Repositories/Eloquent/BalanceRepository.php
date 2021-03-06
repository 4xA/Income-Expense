<?php

namespace App\Repositories\Eloquent;

use App\Balance;
use App\Repositories\BalanceRepositoryInterface;

class BalanceRepository extends BaseRepository implements BalanceRepositoryInterface
{
    protected $model;

    public function __construct(Balance $model)
    {
        $this->model = $model;
    }
}
