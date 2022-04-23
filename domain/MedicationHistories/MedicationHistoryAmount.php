<?php

declare(strict_types=1);

namespace Domain\MedicationHistories;

use Courage\CoFloat\CoPositiveFloat;

class MedicationHistoryAmount extends CoPositiveFloat
{
    public function __construct(float $value)
    {
        parent::__construct($value);
    }
}
