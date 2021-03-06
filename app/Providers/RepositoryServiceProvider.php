<?php

namespace App\Providers;

use App\Repositories\BalanceRepositoryInterface;
use App\Repositories\Eloquent\BalanceRepository;
use App\Repositories\Eloquent\ExpenseRepository;
use App\Repositories\Eloquent\IncomeRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\ExpenseRepositoryInterface;
use App\Repositories\IncomeRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(IncomeRepositoryInterface::class, IncomeRepository::class);
        $this->app->bind(ExpenseRepositoryInterface::class, ExpenseRepository::class);
        $this->app->bind(BalanceRepositoryInterface::class, BalanceRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
