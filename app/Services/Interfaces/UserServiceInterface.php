<?php

declare(strict_types=1);

namespace App\Services\Interfaces;


use Domain\Base\BaseValue;
use Domain\User\UserHashedPassword;
use Domain\User\UserId;

interface UserServiceInterface {
    public function getUser(): array;
    public function login(UserId $userId, BaseValue $rawPassword): array;
    public function register(
        UserId $id,
        UserHashedPassword $hashedPassword,
    ): array;
}
