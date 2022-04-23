<?php

declare(strict_types=1);

namespace Domain\Drugs;

use Domain\Base\BaseValue;

class DrugName extends BaseValue
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
