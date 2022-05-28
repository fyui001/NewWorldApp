<?php

declare(strict_types=1);

namespace Domain\MedicationHistory;

use Courage\CoInt\CoPositiveInteger;
use Domain\Drug\DrugId;
use Domain\User\Id as UserId;
use Illuminate\Pagination\LengthAwarePaginator;

interface MedicationHistoryRepository
{
    public function getPaginator(): LengthAwarePaginator;
    public function getCountMedicationTake(DrugId $drugId): CoPositiveInteger;
    public function getListByUserId(UserId $userId): MedicationHistoryList;
    public function create(
        UserId $userId,
        MedicationHistoryAmount $amount
    ): MedicationHistory;
    public function update(MedicationHistory $medicationHistory): MedicationHistory;
    public function delete(MedicationHistoryId $id): CoPositiveInteger;
}
