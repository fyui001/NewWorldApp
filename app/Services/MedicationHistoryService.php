<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\MedicationHistories\CreateMedicationHistoryRequest;
use App\Models\MedicationHistory;
use App\Models\Drug;
use App\Models\User;
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

    public function createMedicationHistory(CreateMedicationHistoryRequest $request): array {

        $params = $request->only('user_id', 'drug_name', 'amount');
        $drug = Drug::where(['drug_name' => $params['drug_name']])->first();
        $user = User::where(['id' => $params['user_id']])->first();
        if (empty($drug)) {
            return [
                'status' => false,
                'message' => 'Drug not found',
                'errors' => [
                    'key' => 'drug_not_found',
                ],
                'data' => null,
            ];
        }
        if (empty($user)) {
            return [
                'status' => false,
                'message' => 'User not found',
                'errors' => [
                    'key' => 'user_not_found',
                ],
                'data' => null,
            ];
        }
        $result = MedicationHistory::create([
           'user_id' => $params['user_id'],
           'drug_id' => $drug['id'],
           'amount' => $params['amount'],
        ]);

        if (!$result) {
            return [
                'status' => false,
                'message' => 'Failed create medication history',
                'errors' => [
                    'key' => 'failed_create_medication_history',
                ],
                'data' => null,
            ];
        }

        return [
            'status' => true,
            'message' => '',
            'errors' => null,
            'data' => null,
        ];

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
