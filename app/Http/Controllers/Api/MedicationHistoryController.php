<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Services\Interfaces\MedicationHistoryServiceInterface;
use App\Http\Requests\MedicationHistories\CreateMedicationHistoryRequest;

class MedicationHistoryController
{
    protected MedicationHistoryServiceInterface $medicationHistoryService;

    public function __construct(MedicationHistoryServiceInterface $medicationHistoryService) {

        $this->medicationHistoryService = $medicationHistoryService;

    }

    /**
     * Create medication history
     *
     * @param CreateMedicationHistoryRequest $request
     * @return array
     */
    public function create(CreateMedicationHistoryRequest $request): array {

        $response = $this->medicationHistoryService->createMedicationHistory($request);

        if (!$response['status']) {
            return [
                'status' => false,
                'message' => $response['message'],
                'errors' => $response['errors'],
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
