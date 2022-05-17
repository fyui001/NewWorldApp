<?php

declare(strict_types=1);

namespace Domain\AdminUser;

use Courage\CoInt\CoInteger;
use Courage\CoList;
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

    public static function displayNameList(): CoList
    {
        return new CoList([
            self::ROLE_SYSTEM->getValue()->getRawValue() => new CoString('システム管理者'),
            self::ROLE_OPERATOR->getValue()->getRawValue() => new CoString('管理者'),
        ]);
    }

    public function isSystem(): bool
    {
        return match($this) {
            self::ROLE_SYSTEM => true,
            self::ROLE_OPERATOR => false,
        };
    }

    public function isOperator(): bool
    {
        return match($this) {
            self::ROLE_SYSTEM => false,
            self::ROLE_OPERATOR => true,
        };
    }

    public function getValue(): CoInteger
    {
        return new CoInteger($this->value);
    }
}
