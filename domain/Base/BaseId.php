<?php

declare(strict_types=1);

namespace Domain\Base;

use Courage\CoInt\CoPositiveInteger;

abstract class BaseId extends CoPositiveInteger
{
    public function __construct(int $value)
    {
        parent::__construct($value);
    }
}
