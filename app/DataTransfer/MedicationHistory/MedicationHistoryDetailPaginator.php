<?php

declare(strict_types=1);

namespace App\DataTransfer\MedicationHistory;

use Domain\Common\Paginator\Paginate;
use Illuminate\Pagination\LengthAwarePaginator;


class MedicationHistoryDetailPaginator extends LengthAwarePaginator
{
    public function __construct(
        MedicationHistoryDetailList $medicationHistoryDetailList,
        Paginate $paginate,
    ) {
        parent::__construct(
            $medicationHistoryDetailList,
            count($medicationHistoryDetailList),
            $paginate->getPerPage()->getRawValue(),
        );

        $this->appends('per_page', $paginate->getPerPage()->getRawValue());
    }
}
