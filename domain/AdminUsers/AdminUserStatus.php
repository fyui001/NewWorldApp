<?php

declare(strict_types=1);

namespace Domain\AdminUsers;

use Courage\CoInt\CoInteger;
use Courage\CoList;
use Courage\CoString;
use Domain\Base\BaseEnum;

enum AdminUserStatus: int implements BaseEnum
{
    case STATUS_INVALID = 0;
    case STATUS_VALID = 1;

    public function displayName(): Costring
    {
        return match ($this) {
            self::STATUS_INVALID => new CoString('無効'),
            self::STATUS_VALID => new CoString('有効'),
        };
    }

    public static function displayNameList(): CoList
    {
        return new CoList([
            self::STATUS_INVALID->getValue()->getRawValue() => new CoString('無効'),
            self::STATUS_VALID->getValue()->getRawValue() => new CoString('有効'),
        ]);
    }

    public function getValue(): CoInteger
    {
        return new CoInteger($this->value);
    }
}
