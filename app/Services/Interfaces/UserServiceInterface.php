<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use Domain\Common\RawPassword;
use Domain\Common\Token;
use Domain\User\User;
use Domain\User\UserId;

interface UserServiceInterface {
    public function getUserDetail(User $user): array;
    public function login(UserId $userId, RawPassword $rawPassword): array;
    public function register(
        UserId $id,
        RawPassword $rawPassword,
    ): array;
    public function definitiveRegister(Token $definitiveRegisterToken): array;
}
