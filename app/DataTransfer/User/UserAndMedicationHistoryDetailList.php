<?php

declare(strict_types=1);

namespace App\DataTransfer\User;

use App\DataTransfer\MedicationHistory\MedicationHistoryDetailList;
use Courage\CoList;
use Domain\User\User;

class UserAndMedicationHistoryDetailList extends CoList
{
    public function __construct
    (
        User $user,
        MedicationHistoryDetailList $medicationHistoryDetailList
    ) {
        $userAndMedicationHistoryDetailList = [
            'user' => $user->toArray(),
        ];
        $userAndMedicationHistoryDetailList['user']['medicationHistories'] = $medicationHistoryDetailList->toArray();
        parent::__construct($userAndMedicationHistoryDetailList);
    }
}
