<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \Infra\EloquentRepository\AdminUserRepository::class => \App\Policies\AdminUserPolicy::class,
        \Infra\EloquentModels\Drug::class => \App\Policies\DrugPolicy::class,
        \Infra\EloquentModels\MedicationHistory::class => \App\Policies\MedicationHistoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
