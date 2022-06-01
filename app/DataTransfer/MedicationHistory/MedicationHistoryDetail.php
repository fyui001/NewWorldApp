<?php

declare(strict_types=1);

namespace App\DataTransfer\MedicationHistory;

use Domain\MedicationHistory\MedicationHistory;

class MedicationHistoryDetail
{
    private MedicationHistory $medicationHistory;

    public function __construct(MedicationHistory $medicationHistory)
    {
        $this->medicationHistory = $medicationHistory;
    }

    public function getMedicationHistory(): MedicationHistory
    {
        return $this->medicationHistory;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->medicationHistory->getId()->getRawValue(),
            'amount' => $this->medicationHistory->getAmount()->getRawValue(),
            'drug' => $this->medicationHistory->getDrug()->toArray(),
        ];
    }
}
