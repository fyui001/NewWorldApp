<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Http\Requests\Admin\Drugs\CreateDrugRequest;
use App\Http\Requests\Api\Drugs\CreateDrugRequest as ApiCreateDrugRequest;
use App\Http\Requests\Admin\Drugs\UpdateDrugRequest;
use Domain\Drug\DrugId;
use Domain\Drug\DrugName;
use Domain\Drug\DrugUrl;
use Illuminate\Pagination\LengthAwarePaginator;
use Infra\EloquentModels\Drug as DrugModel;

interface DrugServiceInterface
{
    public function getDrugs(): LengthAwarePaginator;
    public function getDrugList(): array;
    public function findDrug(DrugId $drugId): array;
    public function searchDrugByName(DrugName $drugName): array;
    public function createDrug(DrugName $drugName, DrugUrl $url): array;
    public function updateDrug(DrugModel $drug, UpdateDrugRequest $request): array;
    public function deleteDrug(DrugModel $drug): array;
}
