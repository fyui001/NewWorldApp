<?php

declare(strict_types=1);

namespace App\DataTransfer\User;

use Domain\Common\Paginator\Paginate;
use Domain\MedicationHistory\MedicationHistoryCount;
use Illuminate\Pagination\LengthAwarePaginator;

class UserMedicationHistoryPaginator extends LengthAwarePaginator
{
    public function __construct(
        UserMedicationHistoryDetailList $medicationHistoryDetailList,
        MedicationHistoryCount $medicationHistoryCount,
        Paginate $paginate,
    ) {
        parent::__construct(
            $medicationHistoryDetailList->toArray(),
            $medicationHistoryCount->getRawValue(),
            $paginate->getPerPage()->getRawValue(),
        );

        $this->appends('per_page', $paginate->getPerPage()->getRawValue());
    }
}
