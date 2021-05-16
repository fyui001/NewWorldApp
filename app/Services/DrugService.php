<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\Drugs\CreateDrugRequest;
use App\Http\Requests\Drugs\UpdateDrugRequest;
use App\Services\Service as AppService;
use App\Models\Drug;
use App\Services\Interfaces\DrugServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class DrugService extends AppService implements DrugServiceInterface
{

    /**
     * Paginate Drugs
     *
     * @return LengthAwarePaginator
     */
    public function getDrugs(): LengthAwarePaginator {

        return Drug::sortable()->paginate(15);

    }

    /**
     * Get drug list
     *
     * @return array
     */
    public function getDrugList(): array {

        $drugs = Drug::all();
        if ($drugs->isEmpty()) {
            return [
                'status' => false,
                'errors' => [
                    'type' => 'No drug registered',
                ]
            ];
        }

        return [
            'status' => true,
            'data' => [
                'drugs' => $drugs,
            ],
        ];

    }

    /**
     * Create a drug
     *
     * @param CreateDrugRequest $request
     * @return bool
     */
    public function createDrug(CreateDrugRequest $request): array {

        $params = $request->only(['drug_name', 'url']);

        $result = Drug::create([
            'drug_name' => $params['drug_name'],
            'url' => $params['url'],
        ]);

        if (empty($result)) {
            return [
                'status' => false,
                'message' => 'Failed register drug',
                'errors' => [
                    'key' => 'failed_register_drug',
                ],
                'data' => null,
            ];
        }

        return [
            'status' => true,
            'errors' => null,
            'data' => null,
        ];

    }

    /**
     * Update a drug
     *
     * @param Drug $drug
     * @param UpdateDrugRequest $request
     * @return bool
     */
    public function updateDrug(Drug $drug, UpdateDrugRequest $request): array {

        $data = $request->only('drug_name', 'url');

        if (!$drug->update($data)) {
            return [
                'status' => false,
                'message' => 'Failed update drug',
                'errors' => [
                    'key' => 'failed_update_drug',
                ],
                'data' => null,
            ];
        }

        return [
            'status' => true,
            'message' => '',
            'errors' => null,
            'data' => null,
        ];

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
