<?php

declare(strict_types=1);

namespace App\DataTransfer\User;

use Domain\Base\BaseListValue;
use Domain\User\User;

class UserMedicationHistoryDetailList extends BaseListValue
{
    public function __construct
    (
        User $user,
        UserMedicationHistoryList $userMedicationHistoryList,
    ) {
        $userMedicationHistoryDetail = [
            'user' => $user->toArray(),
        ];
        $userMedicationHistoryDetail['user']['medicationHistories'] = $userMedicationHistoryList->map(function(UserMedicationHistory $userMedicationHistory) {
            return $userMedicationHistory->toArray();
        })->toArray();

        parent::__construct($userMedicationHistoryDetail);
    }
}
