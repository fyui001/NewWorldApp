<?php

declare(strict_types=1);

namespace Domain\MedicationHistories;

use Courage\CoInt\CoPositiveInteger;
use Domain\Drugs\DrugId;
use Domain\Users\Id as UserId;
use Illuminate\Pagination\LengthAwarePaginator;

interface MedicationHistoryRepository
{
    public function getPaginator(): LengthAwarePaginator;
    public function getCountMedicationTake(DrugId $drugId): CoPositiveInteger;
    public function create(
        UserId $userId,
        MedicationHistoryAmount $amount
    ): MedicationHistory;
    public function update(MedicationHistory $medicationHistory): MedicationHistory;
    public function delete(MedicationHistoryId $id): CoPositiveInteger;
}
