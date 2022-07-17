<?php

declare(strict_types=1);

namespace Domain\Base;

use Courage\CoInt\CoInteger;

abstract class BaseIntegerValue extends CoInteger
{
    public function __construct(int $value)
    {
        parent::__construct($value);
    }
}
