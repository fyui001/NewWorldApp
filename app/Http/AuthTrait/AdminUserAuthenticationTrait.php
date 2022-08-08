<?php

declare(strict_types=1);

namespace App\Http\AuthTrait;

use Domain\AdminUser\AdminUser;

trait AdminUserAuthenticationTrait
{
    public function adminUser(): AdminUser
    {
        return $this->user('web');
    }
}
