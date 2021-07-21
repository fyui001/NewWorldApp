<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Services\Interfaces\MedicationHistoryServiceInterface;
use App\Http\Requests\MedicationHistories\CreateMedicationHistoryRequest;
use \Illuminate\Http\JsonResponse;

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
     * @return JsonResponse
     */
    public function create(CreateMedicationHistoryRequest $request): JsonResponse
    {

        $response = $this->medicationHistoryService->createMedicationHistory($request);

        if (!$response['status']) {
            if (!empty($response['errors'])) {
                $error = apiErrorResponse($response['errors']['key']);
                return response()->json($error['body'], $error['response_code']);
            }
            $error = apiErrorResponse('internal_server_error');
            return response()->json($error['body'], $error['response_code']);
        }

        return response()->json( [
            'status' => true,
            'message' => '',
            'errors' => null,
            'data' => null,
        ], 200);

    }
}
