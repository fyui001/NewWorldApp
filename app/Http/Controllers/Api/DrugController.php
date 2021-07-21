<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Drugs\IndexDrugRequest;
use App\Http\Requests\Drugs\CreateDrugRequest;
use App\Services\Interfaces\DrugServiceInterface;
use App\Http\Requests\Drugs\ShowDrugRequest;
use \Illuminate\Http\JsonResponse;

class DrugController
{
    protected DrugServiceInterface $drugService;

    public function __construct(DrugServiceInterface $drugService) {

        $this->drugService = $drugService;

    }

    /**
     * Index of drugs
     *
     * @param IndexDrugRequest $request
     * @return JsonResponse
     */
    public function index(IndexDrugRequest $request): JsonResponse
    {

        $response = $this->drugService->getDrugList($request);
        if (!$response['status']) {
            if (!empty($response['errors'])) {
                $error = apiErrorResponse($response['errors']['key']);
                return response()->json($error['body'], $error['response_code']);
            }
            $error = apiErrorResponse('internal_server_error');
            return response()->json($error['body'], $error['response_code']);
        }

        return response()->json([
            'status' => true,
            'message' => '',
            'data' => $response['data'],
        ], 200);

    }

    /**
     * Create the drug
     *
     * @param CreateDrugRequest $request
     * @return JsonResponse
     */
    public function create(CreateDrugRequest $request): JsonResponse
    {

        $response = $this->drugService->createDrug($request);

        if (!$response['status']) {
            if (!$response['status']) {
                if (!empty($response['errors'])) {
                    $error = apiErrorResponse($response['errors']['key']);
                    return response()->json($error['body'], $error['response_code']);
                }
                $error = apiErrorResponse('internal_server_error');
                return response()->json($error['body'], $error['response_code']);
            }
        }

        return response()->json([
            'status' => true,
            'message' => '',
            'errors' => null,
            'data' => null,
        ], 200);

    }

    /**
     * Find a drug
     *
     * @param ShowDrugRequest $request
     * @return JsonResponse
     */
    public function show(ShowDrugRequest $request): JsonResponse
    {

        $response = $this->drugService->findDrug($request);

        if (!$response['status']) {
            if (!$response['status']) {
                if (!empty($response['errors'])) {
                    $error = apiErrorResponse($response['errors']['key']);
                    return response()->json($error['body'], $error['response_code']);
                }
                $error = apiErrorResponse('internal_server_error');
                return response()->json($error['body'], $error['response_code']);
            }
        }

        return response()->json([
            'status' => true,
            'message' => '',
            'errors' => null,
            'data' => $response['data'],
        ], 200);

    }
}
