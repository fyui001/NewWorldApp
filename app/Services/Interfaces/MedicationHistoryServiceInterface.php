<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\Admin\MedicationHistories\UpdateMedicationHistoryRequest;
use Domain\MedicationHistory\MedicationHistory;
use Infra\EloquentModels\MedicationHistory as MedicationHistoryModel;

interface MedicationHistoryServiceInterface
{
    public function getMedicationHistories(): LengthAwarePaginator;
    public function updateMedicationHistory(
        MedicationHistoryModel $medicationHistory,
        UpdateMedicationHistoryRequest $request
    ): MedicationHistory;
}
