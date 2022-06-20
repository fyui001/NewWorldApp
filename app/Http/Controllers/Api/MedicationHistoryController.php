<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\MedicationHistories\CreateMedicationHistoryRequest;
use App\Http\Responder\ApiErrorResponder;
use App\Services\Interfaces\MedicationHistoryServiceInterface;
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

        $response = $this->medicationHistoryService->createMedicationHistory(
            $request->getUserId(),
            $request->getDrugName(),
            $request->getAmount(),
        );

        if (!$response['status']) {
            if (!empty($response['errors'])) {
                $apiErrorResponder =  new ApiErrorResponder($response['errors']['key']);
                $response = $apiErrorResponder->getResponse();
                return response()->json(
                    $response['body'],
                    $response['response_code']
                );
            }
            $apiErrorResponder = new ApiErrorResponder('internal_server_error');
            $errorResponse = $apiErrorResponder->getResponse();
            return response()->json(
                $errorResponse['body'],
                $errorResponse['response_code']
            );
        }

        return response()->json( [
            'status' => true,
            'message' => '',
            'errors' => null,
            'data' => $response['data'],
        ], 200);

    }
}
