<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Services\Interfaces;
use App\Services;
use Laravel\Sanctum\Sanctum;

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
    public function register(): void
    {
        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // 管理画面用のクッキー
        if (request()->is('admin*')) {
            config(['session.cookie' => config('session.cookie_admin')]);
        }

        Paginator::useBootstrap();
        if ($this->app->environment() === 'production') {
            \URL::forceScheme('https');
        }
    }
}
