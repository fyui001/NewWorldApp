<?php

declare(strict_types=1);

namespace Domain\Drugs;

use Courage\CoInt\CoPositiveInteger;

class DrugId extends CoPositiveInteger
{
    public function __construct(int $value)
    {
        parent::__construct($value);
    }
}
