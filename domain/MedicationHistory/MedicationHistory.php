<?php

namespace Domain\MedicationHistory;

use Domain\Drug\Drug;
use Domain\User\User;

class MedicationHistory
{
    private MedicationHistoryId $id;
    private User $user;
    private Drug $drug;
    private MedicationHistoryAmount $amount;

    public function __construct(
        MedicationHistoryId $id,
        User $user,
        Drug $drug,
        MedicationHistoryAmount $amount
    ) {
        $this->id = $id;
        $this->user = $user;
        $this->drug = $drug;
        $this->amount = $amount;
    }

    public function getId(): MedicationHistoryId
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getDrug(): Drug
    {
        return $this->drug;
    }

    public function getAmount(): MedicationHistoryAmount
    {
        return $this->amount;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId()->getRawValue(),
            'userId' => $this->getUser(),
            'drugId' => $this->getDrug(),
            'amount' => $this->getAmount()->getRawValue(),
        ];
    }
}
