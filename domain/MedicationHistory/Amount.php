<?php

declare(strict_types=1);

namespace Domain\MedicationHistory;

use Courage\CoFloat\CoPositiveFloat;

class Amount extends CoPositiveFloat
{
    public function __construct(float $value)
    {
        parent::__construct($value);
    }
}
