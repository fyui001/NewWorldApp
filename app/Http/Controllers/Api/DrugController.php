<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Drugs\IndexDrugRequest;
use App\Http\Requests\Api\Drugs\CreateDrugRequest;
use App\Http\Responder\ApiErrorResponder;
use App\Services\Interfaces\DrugServiceInterface;
use App\Http\Requests\Api\Drugs\ShowDrugRequest;
use \Illuminate\Http\JsonResponse;

class DrugController
{
    protected DrugServiceInterface $drugService;

    public function __construct(DrugServiceInterface $drugService)
    {
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

        $response = $this->drugService->getDrugList();
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

        return response()->json([
            'status' => true,
            'message' => '',
            'errors' => null,
            'data' => null,
        ]);
    }

    /**
     * Find a drug
     *
     * @param ShowDrugRequest $request
     * @return JsonResponse
     */
    public function show(ShowDrugRequest $request): JsonResponse
    {

        $response = $this->drugService->searchDrugByName($request->getDrugName());

        if (!$response['status']) {
            $apiErrorResponder = new ApiErrorResponder($response['errors']['key']);
            $error = $apiErrorResponder->getResponse()->toArray();
            return response()->json($error['body'], $error['response_code']);
        }

        return response()->json([
            'status' => true,
            'message' => '',
            'errors' => null,
            'data' => $response['data']->toArray(),
        ], 200);

    }
}
