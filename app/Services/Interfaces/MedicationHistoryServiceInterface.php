<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\DataTransfer\MedicationHistory\MedicationHistoryDetailPaginator;
use Domain\Common\Paginator\Paginate;
use Domain\MedicationHistory\MedicationHistory;

interface MedicationHistoryServiceInterface
{
    public function getMedicationHistoryPaginator(Paginate $paginate): MedicationHistoryDetailPaginator;
    public function updateMedicationHistory(
        MedicationHistory $medicationHistory,
    ): MedicationHistory;
}
