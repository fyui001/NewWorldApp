<?php

declare(strict_types=1);

namespace App\Http\Api;

use App\Http\Requests\Api\Drugs\CreateDrugRequest;
use App\Http\Requests\Api\Drugs\IndexDrugRequest;
use App\Http\Requests\Api\Drugs\ShowDrugRequest;
use App\Http\Requests\Api\Drugs\ShowNameDrugRequest;
use App\Http\Responder\ApiErrorResponder;
use App\Services\DrugService;
use Illuminate\Http\JsonResponse;

class DrugController
{
    public function __construct(private readonly DrugService $drugService)
    {
    }

    /**
     * Index of drugs
     *
     * @param IndexDrugRequest $request
     * @return JsonResponse
     */
    public function index(IndexDrugRequest $request): JsonResponse|ApiErrorResponder
    {
        $response = $this->drugService->getDrugList();
        if (!$response['status']) {
            if (!$response['status']) {
                return new ApiErrorResponder($response['errors']['key']);
            }
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
    public function create(CreateDrugRequest $request): JsonResponse|ApiErrorResponder
    {
        $response = $this->drugService->createDrug($request->getDrugName(), $request->getUrl());

        if (!$response['status']) {
            if (!$response['status']) {
                return new ApiErrorResponder($response['errors']['key']);
            }
        }

        return response()->json([
            'status' => true,
            'message' => '',
            'errors' => null,
            'data' => null,
        ]);
    }

    public function show(ShowDrugRequest $request): JsonResponse|ApiErrorResponder
    {
        $response = $this->drugService->show($request->getDrugId());

        if (!$response['status']) {
            if (!$response['status']) {
                return new ApiErrorResponder($response['errors']['key']);
            }
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
    public function showName(ShowNameDrugRequest $request): JsonResponse|ApiErrorResponder
    {
        $response = $this->drugService->searchDrugByName($request->getDrugName());

        if (!$response['status']) {
            if (!$response['status']) {
                return new ApiErrorResponder($response['errors']['key']);
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
