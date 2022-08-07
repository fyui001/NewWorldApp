<?php

declare(strict_types=1);

namespace Domain\MedicationHistory;

use Courage\CoInt\CoPositiveInteger;
use Domain\Common\Paginator\Paginate;
use Domain\Drug\DrugId;
use Domain\User\Id;
use Domain\User\UserDomainService;
use Domain\User\UserId;

class MedicationHistoryDomainService
{
    public function __construct(
        private MedicationHistoryRepository $medicationHistoryRepository,
        private UserDomainService $userDomainService,
    ) {
    }

    public function getPaginate(Paginate $paginate): MedicationHistoryList
    {
        return $this->medicationHistoryRepository->getPaginator($paginate);
    }

    public function getCountMedicationTake(DrugId $drugId): CoPositiveInteger
    {
        return $this->medicationHistoryRepository->getCountMedicationTake($drugId);
    }

    public function getListByUserId(Id $userId): MedicationHistoryList
    {
        return $this->medicationHistoryRepository->getListByUserId($userId);
    }

    public function create(
        Id $userId,
        DrugId $drugId,
        MedicationHistoryAmount $amount
    ): MedicationHistory {
        return $this->medicationHistoryRepository->create($userId, $drugId, $amount);
    }

    public function createByUserId(
        UserId $userId,
        DrugId $drugId,
        MedicationHistoryAmount $amount
    ): MedicationHistory {
        $user = $this->userDomainService->getUserByUserId($userId);
        return $this->medicationHistoryRepository->create($user->getId(), $drugId, $amount);
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
