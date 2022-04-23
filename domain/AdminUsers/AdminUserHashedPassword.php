<?php

declare(strict_types=1);

namespace Domain\AdminUsers;

use Domain\Base\BaseHashedValue;

class AdminUserHashedPassword extends BaseHashedValue
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
