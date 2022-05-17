<?php

declare(strict_types=1);

namespace Domain\User;

use Courage\CoInt\CoPositiveInteger;

class Id extends CoPositiveInteger
{
    public function __construct(int $value)
    {
        parent::__construct($value);
    }
}
