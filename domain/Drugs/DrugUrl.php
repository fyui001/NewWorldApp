<?php

declare(strict_types=1);

namespace Domain\Drugs;

use Domain\Base\BaseUrlValue;

class DrugUrl extends BaseUrlValue
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
