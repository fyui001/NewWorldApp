<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use Infra\EloquentModels\AdminUser;

class MedicationHistoryPolicy
{
    public function update(AdminUser $adminUser): Response
    {
        $adminUserDomain = $adminUser->toDomain();

        return ($adminUserDomain->getRole()->isSystem() || $adminUserDomain->getRole()->isOperator())
            ? Response::allow()
            : Response::deny('You do not own system role.');
    }
}
