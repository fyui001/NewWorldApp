<?php

declare(strict_types=1);

namespace App\DataTransfer\User;

use Domain\Drug\Drug;
use Domain\MedicationHistory\MedicationHistory;

class UserMedicationHistoryDetail
{
    public function __construct(
        private readonly MedicationHistory $medicationHistory,
        private readonly Drug $drug,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->medicationHistory->getId()->getRawValue(),
            'drugName' => $this->drug->getName()->getRawValue(),
            'amount' => $this->medicationHistory->getAmount()->getRawValue(),
            'createdAt' => $this->medicationHistory->getCreatedAt()->getDetail(),
        ];
    }
}
