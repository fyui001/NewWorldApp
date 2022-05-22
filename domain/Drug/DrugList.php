<?php

declare(strict_types=1);

namespace Domain\Drug;

use Domain\Base\BaseListValue;

class DrugList extends BaseListValue
{
    public function __construct(array $value)
    {
        parent::__construct($value);
    }
}
