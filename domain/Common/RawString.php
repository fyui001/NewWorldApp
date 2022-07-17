<?php

declare(strict_types=1);

namespace Domain\Common;

use Domain\Base\BaseValue;

class RawString extends BaseValue
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
