<?php

declare(strict_types=1);

namespace Domain\Drugs;

use Illuminate\Pagination\LengthAwarePaginator;

interface DrugRepository
{
    public function findDrug(DrugId $drugId): Drug;
    public function findDrugByName(DrugName $drugName): Drug;
    public function getPaginator(): LengthAwarePaginator;
    public function create(DrugName $drugName, DrugUrl $drugUrl): Drug;
    public function update(Drug $drug): Drug;
    public function delete(DrugId $drugId): void;
}
