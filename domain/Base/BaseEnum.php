<?php

declare(strict_types=1);

namespace Domain\Base;

use Courage\CoInt\CoInteger;
use Courage\CoString;

interface BaseEnum {
    public function displayName(): Costring;
    public function getValue(): CoInteger;
}
