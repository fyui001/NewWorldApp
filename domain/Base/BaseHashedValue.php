<?php

declare(strict_types=1);

namespace Domain\Base;

use Courage\CoString;
use Illuminate\Support\Facades\Hash;

abstract class BaseHashedValue extends CoString
{
    public function __construct(string $value)
    {
        parent::__construct(Hash::make($value));
    }
}
