<?php

namespace App\DataTransfer\User;

use Domain\Base\BaseListValue;
use Domain\User\User;

class UserMedicationHistoryDetailList extends BaseListValue
{
    public function __construct(
        private readonly User $user,
        private readonly array $userMedicationHistoryDetailList,
    ) {
        parent::__construct($this->userMedicationHistoryDetailList);
    }

    public function toArray(): array
    {
        return [
            'user' => [
                'name' => $this->user->getName()->getRawValue(),
            ],
            'medication_history' => $this->userMedicationHistoryDetailList,
        ];
    }
}
