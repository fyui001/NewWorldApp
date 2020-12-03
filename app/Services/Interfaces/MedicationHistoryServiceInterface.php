<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface MedicationHistoryServiceInterface
{
    public function getMedicationHistories(): LengthAwarePaginator;
}
