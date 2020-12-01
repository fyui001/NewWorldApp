<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\Drugs\CreateDrugRequest;
use App\Http\Requests\Drugs\UpdateDrugRequest;
use App\Services\Service as AppService;
use App\Models\Drug;
use App\Services\Interfaces\DrugServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

class DrugService extends AppService implements DrugServiceInterface
{

    public function getDrugs(): LengthAwarePaginator {

        return Drug::paginate(15);

    }

    /**
     * Create a drug
     *
     * @param Request $request
     * @return Drug
     */
    public function createDrug(CreateDrugRequest $request): bool {
        $result = Drug::create([
            'drug_name' => $request->get('drug_name'),
            'url' => $request->get('url'),
        ]);

        if (empty($result)) {
            return false;
        }

        return true;

    }

    public function updateDrug(Drug $drug, UpdateDrugRequest $request): bool {

        $data = $request->only('drug_name', 'url');

        return $drug->update($data);

    }

}
