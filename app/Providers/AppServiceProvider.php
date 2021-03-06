<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Services\Interfaces;
use App\Services;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        Interfaces\AdminUserServiceInterface::class => Services\AdminUserService::class,
        Interfaces\DrugServiceInterface::class => Services\DrugService::class,
        Interfaces\MedicationHistoryServiceInterface::class => Services\MedicationHistoryService::class,
        Interfaces\UserServiceInterface::class => Services\UserService::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        if ($this->app->environment() === 'production') {
            \URL::forceScheme('https');
        }
    }
}
