<?php

namespace Domain\MedicationHistory;

use Domain\Drug\DrugId;
use Domain\User\Id as UserId;

class MedicationHistory
{
    private MedicationHistoryId $id;
    private UserId $userId;
    private DrugId $drugId;
    private MedicationHistoryAmount $amount;

    public function __construct(
        MedicationHistoryId $id,
        UserId $userId,
        DrugId $drugId,
        MedicationHistoryAmount $amount
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->drugId = $drugId;
        $this->amount = $amount;
    }

    public function getId(): MedicationHistoryId
    {
        return $this->id;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getDrugId(): DrugId
    {
        return $this->drugId;
    }

    public function getAmount(): MedicationHistoryAmount
    {
        return $this->amount;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId()->getRawValue(),
            'userId' => $this->getUserId()->getRawValue(),
            'drugId' => $this->getDrugId()->getRawValue(),
            'amount' => $this->getAmount()->getRawValue(),
        ];
    }
}
