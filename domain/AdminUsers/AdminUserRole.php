<?php

declare(strict_types=1);

namespace Domain\AdminUsers;

use Courage\CoInt\CoInteger;
use Courage\CoString;
use Domain\Base\BaseEnum;

enum AdminUserRole: int implements BaseEnum
{
    case ROLE_SYSTEM = 1;
    case ROLE_OPERATOR = 2;

    public function displayName(): Costring
    {
        return match($this) {
            self::ROLE_SYSTEM => new CoString('システム管理者'),
            self::ROLE_OPERATOR => new CoString('管理者'),
        };
    }

    public function getValue(): CoInteger
    {
        return new CoInteger($this->value);
    }
}
