<?php

declare(strict_types=1);

namespace App\Http\Api;

use App\Http\Requests\Api\MedicationHistories\CreateMedicationHistoryRequest;
use App\Http\Responder\ApiErrorResponder;
use App\Services\MedicationHistoryService;
use Illuminate\Http\JsonResponse;

class MedicationHistoryController
{
    public function __construct(
        private readonly MedicationHistoryService $medicationHistoryService,
    ) {
    }

    /**
     * Create medication history
     *
     * @param CreateMedicationHistoryRequest $request
     * @return JsonResponse
     */
    public function create(CreateMedicationHistoryRequest $request): JsonResponse|ApiErrorResponder
    {

        $response = $this->medicationHistoryService->createMedicationHistory(
            $request->getUserId(),
            $request->getDrugName(),
            $request->getAmount(),
        );

        if (!$response['status']) {
            if (!$response['status']) {
                return new ApiErrorResponder($response['errors']['key']);
            }
        }

        return response()->json( [
            'status' => true,
            'message' => '',
            'errors' => null,
            'data' => $response['data'],
        ], 200);

    }
}
