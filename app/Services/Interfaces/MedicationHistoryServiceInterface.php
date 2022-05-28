<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use Domain\MedicationHistory\MedicationHistoryAmount;
use Illuminate\Pagination\LengthAwarePaginator;
use Domain\MedicationHistory\MedicationHistory;
use Infra\EloquentModels\MedicationHistory as MedicationHistoryModel;

interface MedicationHistoryServiceInterface
{
    public function getMedicationHistories(): LengthAwarePaginator;
    public function updateMedicationHistory(
        MedicationHistoryModel $medicationHistory,
        MedicationHistoryAmount $amount,
    ): MedicationHistory;
}
