<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MedicationHistory;
use App\Services\Service as AppService;
use App\Services\Interfaces\MedicationHistoryServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class MedicationHistoryService extends AppService implements MedicationHistoryServiceInterface
{

    /**
     * Get all medication history
     *
     * @return LengthAwarePaginator
     */
    public function getMedicationHistories(): LengthAwarePaginator {

        return MedicationHistory::orderBy('id', 'desc')->paginate(15);

    }

}
