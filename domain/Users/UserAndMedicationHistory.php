<?php

declare(strict_types=1);

namespace Domain\Users;

use Domain\Base\BaseListValue;
use Domain\MedicationHistories\MedicationHistoryList;

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
