<?php

declare(strict_types=1);

namespace App\Http\AuthTrait;

use Domain\User\User;

trait UserAuthenticationTrait
{
    public function loginUser(): ?User
    {
        /** @var \App\Auth\User $user */
        $user = $this->user('api');
        return !is_null($user) ? $user->getUser() : null;
    }
}
