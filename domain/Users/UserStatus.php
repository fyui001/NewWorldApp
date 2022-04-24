<?php

declare(strict_types=1);

namespace Domain\Users;

use Courage\CoInt\CoInteger;
use Courage\CoString;
use Domain\Base\BaseEnum;

enum UserStatus: int implements BaseEnum
{
    case STATUS_UNREGISTERED = 0;
    case STATUS_VALID = 1;
    case STATUS_DELETED = 2;

    public function displayName(): Costring
    {
        return match ($this) {
            self::STATUS_UNREGISTERED => new CoString('未登録'),
            self::STATUS_VALID => new CoString('有効'),
            self::STATUS_DELETED => new CoString('無効'),
        };
    }

    public function rowString(): CoString
    {
        return match ($this) {
            self::STATUS_UNREGISTERED => new CoString('unregistered'),
            self::STATUS_VALID => new CoString('valid'),
            self::STATUS_DELETED => new CoString('deleted'),
        };
    }

    public function getValue(): CoInteger
    {
        return new CoInteger($this->value);
    }

    public function isRegistered(): bool
    {
        return $this === self::STATUS_VALID;
    }
}
