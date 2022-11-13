<?php

declare(strict_types=1);

namespace Domain\User;

use Domain\Common\HashedPassword;
use Domain\Common\Token;
use Domain\User\DefinitiveRegisterToken\DefinitiveRegisterToken;

interface UserRepository
{
    public function get(Id $id): User;
    public function getUserByUserId(UserId $userId): User;
    public function userRegister(
        Id $id,
        HashedPassword $password,
        UserStatus $userStatus
    ): bool;
    public function definitiveRegister(Token $token): bool;
    public function getDefinitiveRegisterToken(Id $id): DefinitiveRegisterToken;
}
