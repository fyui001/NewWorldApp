<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use Domain\MedicationHistory\MedicationHistory;

interface MedicationHistoryServiceInterface
{
    public function getMedicationHistories(): LengthAwarePaginator;
    public function updateMedicationHistory(
        MedicationHistory $medicationHistory,
    ): MedicationHistory;
}
