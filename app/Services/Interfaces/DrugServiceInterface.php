<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Models\Drug;
use App\Http\Requests\Drugs\CreateDrugRequest;
use App\Http\Requests\Drugs\UpdateDrugRequest;
use Illuminate\Pagination\LengthAwarePaginator;

interface DrugServiceInterface
{
    public function getDrugs(): LengthAwarePaginator;
    public function createDrug(CreateDrugRequest $request): bool;
    public function updateDrug(Drug $drug, UpdateDrugRequest $request): bool;
    public function deleteDrug(Drug $drug):  array ;
}
