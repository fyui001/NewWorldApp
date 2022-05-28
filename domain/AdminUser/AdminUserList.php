<?php

declare(strict_types=1);

namespace Domain\AdminUser;

use Domain\Base\BaseListValue;

class AdminUserList extends BaseListValue
{
    public function __construct(array $value)
    {
        parent::__construct($value);
    }
}
