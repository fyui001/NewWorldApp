<?php

declare(strict_types=1);

namespace Domain\User;

use Domain\Base\BaseEnum;
use Domain\Common\RawInteger;
use Domain\Common\RawString;

enum UserStatus: int implements BaseEnum
{
    case STATUS_UNREGISTERED = 0;
    case STATUS_VALID = 1;
    case STATUS_DELETED = 2;

    public function displayName(): RawString
    {
        return match ($this) {
            self::STATUS_UNREGISTERED => new RawString('未登録'),
            self::STATUS_VALID => new RawString('有効'),
            self::STATUS_DELETED => new RawString('無効'),
        };
    }

    public function rawString(): RawString
    {
        return match ($this) {
            self::STATUS_UNREGISTERED => new RawString('unregistered'),
            self::STATUS_VALID => new RawString('valid'),
            self::STATUS_DELETED => new RawString('deleted'),
        };
    }

    public function getValue(): RawInteger
    {
        return new RawInteger($this->value);
    }

    public function isRegistered(): bool
    {
        return $this === self::STATUS_VALID;
    }

    public function isUnregistered(): bool
    {
        return $this === self::STATUS_UNREGISTERED;
    }
}
