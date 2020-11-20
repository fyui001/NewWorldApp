<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\AdminUser;

class DrugPolicy
{

    public function create(AdminUser $user): bool {

        if (me('role') === AdminUser::ROLE_SYSTEM || me('role') === AdminUser::ROLE_OPERATOR) {
            return true;
        }

        return false;

    }

    public function update(AdminUser $user): bool {

        if (me('role') === AdminUser::ROLE_SYSTEM || me('role') === AdminUser::ROLE_OPERATOR) {
            return true;
        }

        return false;

    }

}
