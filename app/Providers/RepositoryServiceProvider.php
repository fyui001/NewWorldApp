<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Domain;
use Infra\EloquentRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        Domain\AdminUsers\AdminUserRepository::class => EloquentRepository\AdminUserRepository::class,
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
