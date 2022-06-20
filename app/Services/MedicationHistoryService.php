<?php

declare(strict_types=1);

namespace App\Services;

use Domain\Drug\DrugDomainService;
use Domain\Drug\DrugName;
use Domain\MedicationHistory\MedicationHistory;
use Domain\MedicationHistory\MedicationHistoryAmount;
use Domain\MedicationHistory\MedicationHistoryDomainService;
use Domain\User\Id;
use Infra\EloquentModels\MedicationHistory as MedicationHistoryModel;
use App\Services\Service as AppService;
use App\Services\Interfaces\MedicationHistoryServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class MedicationHistoryService extends AppService implements MedicationHistoryServiceInterface
{
    public function __construct(
        private MedicationHistoryDomainService $medicationHistoryDomainService,
        private DrugDomainService $drugDomainService,
    ){
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

    public function createMedicationHistory(Id $userId, DrugName $drugName, MedicationHistoryAmount $amount): array {
        $drug = $this->drugDomainService->findDrugByName($drugName);
        $result = $this->medicationHistoryDomainService->create($userId, $drug->getId(), $amount);
        if (empty($result->toArray())) {
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
            'data' => $result->toArray(),
        ];
    }

    /**
     * Update medication history
     *
     * @param MedicationHistoryModel $medicationHistory
     * @param MedicationHistoryAmount $amount
     * @return MedicationHistory
     */
    public function updateMedicationHistory(
        MedicationHistoryModel $medicationHistory,
        MedicationHistoryAmount $amount,
    ): MedicationHistory {
        $medicationHistoryDomain = $medicationHistory->toDomain();

        return $this->medicationHistoryDomainService->update($medicationHistoryDomain);
    }

}
