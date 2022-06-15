<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Domain;
use Infra\EloquentRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        Domain\AdminUser\AdminUserRepository::class => EloquentRepository\AdminUserRepository::class,
        Domain\Drug\DrugRepository::class => EloquentRepository\DrugRepository::class,
        Domain\MedicationHistory\MedicationHistoryRepository::class => EloquentRepository\MedicationHistoryRepository::class,
        Domain\User\UserRepository::class => EloquentRepository\UserRepository::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
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
