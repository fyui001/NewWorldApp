<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\Admin\Drugs\CreateDrugRequest;
use App\Http\Requests\Api\Drugs\CreateDrugRequest as ApiCreateDrugRequest;
use App\Http\Requests\Admin\Drugs\UpdateDrugRequest;
use App\Services\Service as AppService;
use Courage\CoInt\CoInteger;
use Domain\Drug\Drug;
use Domain\Drug\DrugDomainService;
use Domain\Drug\DrugId;
use App\Services\Interfaces\DrugServiceInterface;
use Domain\Drug\DrugName;
use Domain\Exception\NotFoundException;
use Domain\MedicationHistory\MedicationHistoryDomainService;
use Illuminate\Pagination\LengthAwarePaginator;
use Infra\EloquentModels\Drug as DrugModel;

class DrugService extends AppService implements DrugServiceInterface
{
    private DrugDomainService $drugDomainService;
    private MedicationHistoryDomainService $medicationHistoryDomainService;

    public function __construct(
        DrugDomainService $drugDomainService,
        MedicationHistoryDomainService $medicationHistoryDomainService
    ) {
        $this->drugDomainService = $drugDomainService;
        $this->medicationHistoryDomainService = $medicationHistoryDomainService;
    }

    /**
     * Paginate Drugs
     *
     * @return LengthAwarePaginator
     */
    public function getDrugs(): LengthAwarePaginator
    {
        return $this->drugDomainService->getPaginator();
    }

    public function getDrugList(): array
    {
        $drugList = $this->drugDomainService->getDrugList()->map(function(Drug $domain) {
            return $domain->toArray();
        })->toArray();

        if (empty($drugList)) {
            return [
                'status' => false,
                'errors' => [
                    'key' => 'drug_notfound',
                ],
                'data' => null,
            ];
        }

        return [
            'status' => true,
            'errors' => null,
            'data' => $drugList,
        ];
    }

    /**
     * Find a drug
     *
     * @param DrugId $drugId
     * @return array
     */
    public function findDrug(DrugId $drugId): array
    {
        $drug = $this->drugDomainService->findDrug($drugId);

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
     * Find drug by name
     *
     * @param DrugName $drugName
     * @return Drug
     */
    public function searchDrugByName(DrugName $drugName): array
    {
        $drug = $this->drugDomainService->findDrugByName($drugName);

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
            'data' => $drug->toArray(),
        ];
    }

    /**
     * Create a drug
     *
     * @param CreateDrugRequest|ApiCreateDrugRequest $request
     * @return array
     */
    public function createDrug(CreateDrugRequest|ApiCreateDrugRequest $request): array
    {
        $result = $this->drugDomainService->createDrug(
            $request->getDrugName(),
            $request->getUrl()
        );

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
            'data' => $result,
        ];
    }

    /**
     * Update a drug
     *
     * @param DrugModel $drug
     * @param UpdateDrugRequest $request
     * @return array
     */
    public function updateDrug(DrugModel $drug, UpdateDrugRequest $request): array
    {

        $drugDomain = new Drug(
            new DrugId((int)$drug->id),
            $request->getName(),
            $request->getUrl()
        );

        $result = $this->drugDomainService->updateDrug($drugDomain);

        if (!$result) {
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
     * @param DrugModel $drug
     * @return array
     */
    public function deleteDrug(DrugModel $drug): array
    {
        try {
            $medicationHistories = $this->medicationHistoryDomainService->getCountMedicationTake(
                $drug->toDomain()->getId()
            );

            if ($medicationHistories->isLessThan(new CoInteger(0))) {
                return [
                    'status' => false,
                    'message' => 'Have a medication history',
                    'errors' => [
                        'key' => 'have_a_medication_history',
                    ],
                    'data' => null,
                ];
            }

            $this->drugDomainService->deleteDrug($drug->toDomain()->getId());

            return [
                'status' => true,
                'message' => '',
                'errors' => null,
                'data' => null,
            ];
        } catch (NotFoundException $e) {
            return [
                'status' => false,
                'message' => 'Failed to delete',
                'errors' => [
                    'key' => 'failed_to_delete',
                ],
                'data' => null,
            ];
        }
    }
}
