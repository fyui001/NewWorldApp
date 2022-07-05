<?php

declare(strict_types=1);

namespace Domain\Base;

use Courage\CoString;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Facades\Hash;

abstract class BaseHashedValue extends CoString
{
    public function check(Hasher $hasher, BaseValue $rawPassword): bool
    {
        return $hasher->check($rawPassword->getRawValue(), $this->getRawValue());
    }
}
