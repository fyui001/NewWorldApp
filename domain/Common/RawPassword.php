<?php

declare(strict_types=1);

namespace Domain\Common;

use Domain\Base\BaseValue;
use Illuminate\Contracts\Hashing\Hasher;

class RawPassword extends BaseValue
{
    public function hash(Hasher $hasher): HashedPassword
    {
        return new HashedPassword($hasher->make($this->getRawValue()));
    }
}
