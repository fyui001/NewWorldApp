<?php

declare(strict_types=1);

namespace App\DataTransfer\MedicationHistory;

use Domain\Common\Paginator\Paginate;
use Domain\MedicationHistory\MedicationHistoryCount;
use Illuminate\Pagination\LengthAwarePaginator;


class MedicationHistoryDetailPaginator extends LengthAwarePaginator
{
    public function __construct(
        MedicationHistoryDetailList $medicationHistoryDetailList,
        MedicationHistoryCount $medicationHistoryCount,
        Paginate $paginate,
    ) {
        parent::__construct(
            $medicationHistoryDetailList,
            $medicationHistoryCount->getRawValue(),
            $paginate->getPerPage()->getRawValue(),
        );

        $this->appends('per_page', $paginate->getPerPage()->getRawValue());
    }
}
