<?php

declare(strict_types=1);

namespace Domain\User\DefinitiveRegisterToken;

use Domain\Common\ExpiredAt;
use Domain\Common\Token;
use Domain\User\Id as UserId;

class DefinitiveRegisterToken
{
    public function __construct(
        private UserId $userId,
        private Token $token,
        private ExpiredAt $expiredAt,
    ) {
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getToken(): Token
    {
        return $this->token;
    }
}
