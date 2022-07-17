<?php

declare(strict_types=1);

namespace Domain\AdminUser;

use Domain\Base\BaseEnum;
use Domain\Common\ListValue;
use Domain\Common\RawInteger;
use Domain\Common\RawString;

enum AdminUserStatus: int implements BaseEnum
{
    case STATUS_INVALID = 0;
    case STATUS_VALID = 1;

    public function displayName(): RawString
    {
        return match ($this) {
            self::STATUS_INVALID => new RawString('無効'),
            self::STATUS_VALID => new RawString('有効'),
        };
    }

    public static function displayNameList(): ListValue
    {
        return new ListValue([
            self::STATUS_INVALID->getValue()->getRawValue() => new RawString('無効'),
            self::STATUS_VALID->getValue()->getRawValue() => new RawString('有効'),
        ]);
    }

    public function getValue(): RawInteger
    {
        return new RawInteger($this->value);
    }
}
