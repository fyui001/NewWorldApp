<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\Admin\MedicationHistories\UpdateMedicationHistoryRequest;
use App\Http\Requests\Api\MedicationHistories\CreateMedicationHistoryRequest;
use Domain\Drugs\DrugId;
use Domain\MedicationHistories\MedicationHistory;
use Domain\MedicationHistories\MedicationHistoryDomainService;
use Domain\MedicationHistories\MedicationHistoryId;
use Domain\Users\Id;
use Infra\EloquentModels\MedicationHistory as MedicationHistoryModel;
use Infra\EloquentModels\Drug;
use Infra\EloquentModels\User;
use App\Services\Service as AppService;
use App\Services\Interfaces\MedicationHistoryServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class MedicationHistoryService extends AppService implements MedicationHistoryServiceInterface
{
    private MedicationHistoryDomainService $medicationHistoryDomainService;

    public function __construct(MedicationHistoryDomainService $medicationHistoryDomainService)
    {
        $this->medicationHistoryDomainService = $medicationHistoryDomainService;
    }

    /**
     * Get all medication history
     *
     * @return LengthAwarePaginator
     */
    public function getMedicationHistories(): LengthAwarePaginator
    {
        return $this->medicationHistoryDomainService->getPaginate();
    }

    public function createMedicationHistory(CreateMedicationHistoryRequest $request): array {

        $params = $request->only('user_id', 'drug_name', 'amount');
        $drug = Drug::where(['drug_name' => $params['drug_name']])->first();
        $user = User::where(['id' => $params['user_id']])->first();
        if (empty($drug)) {
            return [
                'status' => false,
                'errors' => [
                    'key' => 'drug_notfound',
                ]
            ];
        }
        if (empty($user)) {
            return [
                'status' => false,
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
                'errors' => [
                    'key' => 'failed_create_medication_history',
                ],
                'data' => null,
            ];
        }

        return [
            'status' => true,
            'errors' => null,
            'data' => $result,
        ];

    }

    /**
     * Update medication history
     *
     * @param MedicationHistoryModel $medicationHistory
     * @param UpdateMedicationHistoryRequest $request
     * @return bool
     */
    public function updateMedicationHistory(
        MedicationHistoryModel $medicationHistory, UpdateMedicationHistoryRequest $request
    ): MedicationHistory {
        $medicationHistoryDomain = new MedicationHistory(
            new MedicationHistoryId((int)$medicationHistory->id),
            new Id($medicationHistory->user_id),
            new DrugId($medicationHistory->drug_id),
            $request->getAmount()
        );

        return $this->medicationHistoryDomainService->update($medicationHistoryDomain);
    }

}
