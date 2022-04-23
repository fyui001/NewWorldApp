<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Http\Requests\Admin\Drugs\CreateDrugRequest;
use App\Http\Requests\Admin\Drugs\UpdateDrugRequest;
use Domain\Drugs\DrugId;
use Domain\Drugs\DrugName;
use Illuminate\Pagination\LengthAwarePaginator;
use Infra\EloquentModels\Drug as DrugModel;

interface DrugServiceInterface
{
    public function getDrugs(): LengthAwarePaginator;
    public function findDrug(DrugId $drugId): array;
    public function searchDrugByName(DrugName $drugName): array;
    public function createDrug(CreateDrugRequest $request): array;
    public function updateDrug(DrugModel $drug, UpdateDrugRequest $request): array;
    public function deleteDrug(DrugModel $drug): array;
}
