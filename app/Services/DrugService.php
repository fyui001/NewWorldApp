<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\Drugs\IndexDrugRequest;
use App\Http\Requests\Drugs\CreateDrugRequest;
use App\Http\Requests\Drugs\UpdateDrugRequest;
use App\Http\Requests\Drugs\ShowDrugRequest;
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
     * @param IndexDrugRequest $request
     * @return array
     */
    public function getDrugList(IndexDrugRequest $request): array {

        $orderBy = $request->input('order_by', 'id');
        $sortOrder = $request->input('sort', 'asc');

        if ($request->has('page')) {
            $perPage = $request->input('per_page', 10);
            $drugs = Drug::select('*')
                ->sortSetting($orderBy, $sortOrder)
                ->paginate($perPage);
        } else {
            $drugs = Drug::select('*')
                ->sortSetting($orderBy, $sortOrder)
                ->get();
        }

        return [
            'status' => true,
            'errors' => null,
            'data' => $drugs,
        ];

    }

    /**
     * Find a drug
     *
     * @param ShowDrugRequest $request
     * @return array
     */
    public function findDrug(ShowDrugRequest $request): array {

        $params = $request->only('drug_name');
        $drug = Drug::where(['drug_name' => $params['drug_name']])->first();

        if (empty($drug)) {
            return [
                'status' => false,
                'errors' => [
                    'key' => 'drug_notfound',
                ],
                'data' => null
            ];
        }

        return [
            'status' => true,
            'errors' => null,
            'data' => $drug,
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
                'errors' => [
                    'key' => 'failed_register_drug',
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
                'data' => null,
            ];
        }

        if (!$drug->delete()) {
            return [
                'status' => false,
                'message' => 'Failed to delete',
                'errors' => [
                    'key' => 'failed_to_delete',
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

}
