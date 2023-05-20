<?php

declare(strict_types=1);

namespace App\Http\Api;

use App\Http\Requests\Api\Drugs\IndexDrugRequest;
use App\Http\Requests\Api\Drugs\ShowDrugRequest;
use App\Http\Requests\Api\Drugs\ShowNameDrugRequest;
use App\Http\Responder\ApiErrorResponder;
use App\Services\Interfaces\DrugServiceInterface;
use Illuminate\Http\JsonResponse;

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
        $response = $this->drugService->createDrug($request->getDrugName(), $request->getUrl());

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

    public function show(ShowDrugRequest $request): JsonResponse
    {
        $response = $this->drugService->show($request->getDrugId());

        if (!$response['status']) {
            $apiErrorResponder = new ApiErrorResponder($response['errors']['key']);
            $error = $apiErrorResponder->getResponse()->toArray();
            return response()->json($error['body'], $error['response_code']);
        }

        return response()->json([
            'status' => true,
            'message' => '',
            'errors' => null,
            'data' => $response['data'],
        ], 200);
    }

    /**
     * Find a drug by name
     *
     * @param ShowNameDrugRequest $request
     * @return JsonResponse
     */
    public function showName(ShowNameDrugRequest $request): JsonResponse
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
            'data' => $response['data'],
        ], 200);

    }
}
