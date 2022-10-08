<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\DataTransfer\Drug\DrugPaginator;
use App\Http\Requests\Admin\Drugs\UpdateDrugRequest;
use Domain\Common\Paginator\Paginate;
use Domain\Drug\DrugId;
use Domain\Drug\DrugName;
use Domain\Drug\DrugUrl;
use Infra\EloquentModels\Drug as DrugModel;

interface DrugServiceInterface
{
    public function getDrugsPaginator(Paginate $paginate): DrugPaginator;
    public function getDrugList(): array;
    public function show(DrugId $drugId): array;
    public function searchDrugByName(DrugName $drugName): array;
    public function createDrug(DrugName $drugName, DrugUrl $url): array;
    public function updateDrug(DrugModel $drug, UpdateDrugRequest $request): array;
    public function deleteDrug(DrugModel $drug): array;
}
