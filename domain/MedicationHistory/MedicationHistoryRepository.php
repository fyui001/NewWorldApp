<?php

declare(strict_types=1);

namespace Domain\MedicationHistory;

use Courage\CoInt\CoPositiveInteger;
use Domain\Common\Paginator\Paginate;
use Domain\Drug\DrugId;
use Domain\User\Id;
use Illuminate\Pagination\LengthAwarePaginator;

interface MedicationHistoryRepository
{
    public function getPaginator(Paginate $paginate): MedicationHistoryList;
    public function getCount(): MedicationHistoryCount;
    public function getCountMedicationTake(DrugId $drugId): CoPositiveInteger;
    public function getListByUserId(Id $userId): MedicationHistoryList;
    public function create(
        Id $userId,
        DrugId $drugId,
        MedicationHistoryAmount $amount
    ): MedicationHistory;
    public function update(MedicationHistory $medicationHistory): MedicationHistory;
    public function delete(MedicationHistoryId $id): CoPositiveInteger;
}
