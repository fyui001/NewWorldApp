<?php

declare(strict_types=1);

namespace Domain\AdminUser;

use Domain\Base\BaseHashedValue;
use Illuminate\Support\Facades\Hash;

class AdminUserHashedPassword extends BaseHashedValue
{
    public static function make(string $rawPassWord): self
    {
        return new self(Hash::make($rawPassWord));
    }
}
