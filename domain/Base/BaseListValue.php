<?php

declare(strict_types=1);

namespace Domain\Base;

use Courage\CoList;

abstract class BaseListValue extends CoList
{
    public function __construct(array $value)
    {
        parent::__construct($value);
    }
}
