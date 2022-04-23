<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Domain;
use Infra\EloquentRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        Domain\AdminUsers\AdminUserRepository::class => EloquentRepository\AdminUserRepository::class,
        Domain\Drugs\DrugRepository::class => EloquentRepository\DrugRepository::class,
        Domain\MedicationHistories\MedicationHistoryRepository::class => EloquentRepository\MedicationHistoryRepository::class,
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
