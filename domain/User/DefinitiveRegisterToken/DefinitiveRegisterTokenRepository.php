<?php

declare(strict_types=1);

namespace Domain\User\DefinitiveRegisterToken;

use Domain\Common\Token;
use Domain\User\Id;

interface DefinitiveRegisterTokenRepository
{
    public function getValidDefinitiveRegisterToken(Id $id): DefinitiveRegisterToken;
    public function create(Id $id): DefinitiveRegisterToken;
    public function tokenPutToUse(Token $token): DefinitiveRegisterToken;
}
