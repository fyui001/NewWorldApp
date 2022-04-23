<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Domain\AdminUsers\AdminUserRole;
use Illuminate\Support\Str;

class Accessible
{

    public function handle($request, Closure $next, $guards = null) {
        $currentUser = \Auth::user();

        // Current route is not one of available routes
        if ($currentUser) {
            $accessibleRoutes = $this->getAccessibleRoutes($currentUser->role);

            abort_unless($this->containsCurrentRoute($accessibleRoutes), 403);
        }

        return $next($request);
    }

    /**
     *
     *
     * @param int $roleId
     * @return array
     */
    protected function getAccessibleRoutes(int $roleId): array {

        $routes = [
            AdminUserRole::ROLE_SYSTEM->getValue()->getRawValue() => [
                'auth.*',
                'admin_users.*',
                'top_page',
                'drugs.*',
                'medication_histories.*',
            ],
            AdminUserRole::ROLE_OPERATOR->getValue()->getRawValue() => [
                'auth.*',
                'admin_users.api_token',
                'admin_users.api_token.update',
                'top_page',
                'drugs.*',
                'medication_histories.*',
            ],
        ];

        return data_get($routes, $roleId, []);

    }

    /**
     *
     *
     * @param array $availableRoutes
     * @return bool
     */
    protected function containsCurrentRoute(array $availableRoutes): bool
    {

        $currentRoute = \Route::currentRouteName();

        foreach ($availableRoutes as $route) {
            if (Str::is($route, $currentRoute)) {
                return true;
            }
        }

        return false;
    }

}
