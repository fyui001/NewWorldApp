<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MedicationHistory;
use App\Services\Service as AppService;
use App\Services\Interfaces\MedicationHistoryServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\MedicationHistories\UpdateMedicationHistoryRequest;

class MedicationHistoryService extends AppService implements MedicationHistoryServiceInterface
{

    /**
     * Get all medication history
     *
     * @return LengthAwarePaginator
     */
    public function getMedicationHistories(): LengthAwarePaginator {

        return MedicationHistory::sortable()->orderBy('id', 'desc')->paginate(15);

    }

    /**
     * Update medication history
     *
     * @param MedicationHistory $medicationHistory
     * @param UpdateMedicationHistoryRequest $request
     * @return bool
     */
    public function updateMedicationHistory(MedicationHistory $medicationHistory, UpdateMedicationHistoryRequest $request): bool {
        $params = $request->only('amount');
        return $medicationHistory->update($params);
    }

}
