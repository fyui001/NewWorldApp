<?php

declare(strict_types=1);

namespace Domain\Base;

use Courage\CoString;
use Domain\Exceptions\InvalidArgumentException;

abstract class BaseUrlValue extends CoString
{
    public function __construct(string $value)
    {
        if (!parse_url($value)) {
            throw new InvalidArgumentException();
        }

        parent::__construct($value);
    }
}

