<?php

declare(strict_types=1);

namespace Domain\MedicationHistory;

use Courage\CoInt\CoPositiveInteger;
use Domain\Drug\DrugId;
use Domain\User\Id as UserId;
use Illuminate\Pagination\LengthAwarePaginator;

class MedicationHistoryDomainService
{
    private MedicationHistoryRepository $medicationHistoryRepository;

    public function __construct(MedicationHistoryRepository $medicationHistoryRepository)
    {
        $this->medicationHistoryRepository = $medicationHistoryRepository;
    }

    public function getPaginate(): LengthAwarePaginator
    {
        return $this->medicationHistoryRepository->getPaginator();
    }

    public function getCountMedicationTake(DrugId $drugId): CoPositiveInteger
    {
        return $this->medicationHistoryRepository->getCountMedicationTake($drugId);
    }

    public function create(
        UserId $userId,
        MedicationHistoryAmount $amount
    ): MedicationHistory {
        return $this->medicationHistoryRepository->create($userId, $amount);
    }

    public function update(MedicationHistory $medicationHistory): MedicationHistory
    {
        return $this->medicationHistoryRepository->update($medicationHistory);
    }

    public function delete(MedicationHistoryId $id): CoPositiveInteger
    {
        return $this->medicationHistoryRepository->delete($id);
    }
}
