<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\DataTransfer\Drug\DrugPaginator;
use Domain\Common\Paginator\Paginate;
use Domain\Drug\DrugId;
use Domain\Drug\DrugName;
use Domain\Drug\DrugUrl;

interface DrugServiceInterface
{
    public function getDrugsPaginator(Paginate $paginate): DrugPaginator;
    public function getDrugList(): array;
    public function show(DrugId $drugId): array;
    public function searchDrugByName(DrugName $drugName): array;
    public function createDrug(DrugName $drugName, DrugUrl $url): array;
    public function updateDrug(
        DrugId $drugId,
        DrugName $drugName,
        DrugUrl $drugUrl,
    ): array;
    public function deleteDrug(DrugId $drugId): array;
}
