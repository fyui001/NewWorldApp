<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\MedicationHistory;
use App\Http\Requests\MedicationHistories\UpdateMedicationHistoryRequest;
use App\Http\Requests\MedicationHistories\CreateMedicationHistoryRequest;
interface MedicationHistoryServiceInterface
{
    public function getMedicationHistories(): LengthAwarePaginator;
    public function createMedicationHistory(CreateMedicationHistoryRequest $request): array;
    public function updateMedicationHistory(MedicationHistory $medicationHistory, UpdateMedicationHistoryRequest $request): bool;
}
