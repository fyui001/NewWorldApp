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
     * @param CreateDrugRequest $request
     * @return bool
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

    /**
     * Update a drug
     *
     * @param Drug $drug
     * @param UpdateDrugRequest $request
     * @return bool
     */
    public function updateDrug(Drug $drug, UpdateDrugRequest $request): bool {

        $data = $request->only('drug_name', 'url');

        return $drug->update($data);

    }

    /**
     * Delete the drug
     *
     * @param Drug $drug
     */
    public function deleteDrug(Drug $drug): array {

        $medicationHistories = $drug::with('medicationHistories.drug')->where([
            'id' => $drug->id,
        ])->first()['medicationHistories'];

        if ($medicationHistories->isNotEmpty()) {
            return [
                'status' => false,
                'message' => 'Have a medication history',
                'errors' => [
                    'key' => 'have_a_medication_history',
                ],
            ];
        }

        if (!$drug->delete()) {
            return [
                'status' => false,
                'message' => 'Failed to delete',
                'errors' => [
                    'key' => 'failed_to_delete',
                ],
            ];
        }

        return [
            'status' => true,
        ];
    }

}
