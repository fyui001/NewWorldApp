<?php

declare(strict_types=1);

namespace Domain\User;

use Domain\Common\HashedPassword;

interface UserRepository
{
    public function get(Id $id): User;
    public function getUserByUserId(UserId $userId): User;
    public function userRegister(
        Id $id,
        HashedPassword $password,
        UserStatus $userStatus
    ): bool;
}
