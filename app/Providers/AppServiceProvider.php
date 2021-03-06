<?php

namespace App\Providers;

use App\BalanceEntry;
use App\Observers\BalanceEntryObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        BalanceEntry::observe(BalanceEntryObserver::class);
    }
}
