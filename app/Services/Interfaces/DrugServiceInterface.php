<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Models\Drug;
use App\Http\Requests\Drugs\IndexDrugRequest;
use App\Http\Requests\Drugs\CreateDrugRequest;
use App\Http\Requests\Drugs\UpdateDrugRequest;
use App\Http\Requests\Drugs\ShowDrugRequest;
use Illuminate\Pagination\LengthAwarePaginator;

interface DrugServiceInterface
{
    public function getDrugs(): LengthAwarePaginator;
    public function getDrugList(IndexDrugRequest $request): array;
    public function findDrug(ShowDrugRequest $request): array;
    public function createDrug(CreateDrugRequest $request): array;
    public function updateDrug(Drug $drug, UpdateDrugRequest $request): array;
    public function deleteDrug(Drug $drug):  array ;
}
