<?php

declare(strict_types=1);

namespace Domain\User;

use Domain\Base\BaseListValue;
use Domain\MedicationHistory\MedicationHistoryList;

class UserAndMedicationHistory extends BaseListValue
{
    public function __construct
    (
        User $user,
        MedicationHistoryList $medicationHistoryList
    ) {
        parent::__construct([
            'user'=> $user->toArray(),
            'medicationHistories' => $medicationHistoryList->toArray(),
        ]);
    }
}
