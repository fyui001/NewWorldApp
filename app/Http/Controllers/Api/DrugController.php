<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Drugs\CreateDrugRequest;
use App\Services\Interfaces\DrugServiceInterface;
use App\Http\Requests\Drugs\ShowDrugRequest;

class DrugController
{
    protected DrugServiceInterface $drugService;

    public function __construct(DrugServiceInterface $drugService) {

        $this->drugService = $drugService;

    }

    /**
     * Index of drugs
     *
     * @return array
     */
    public function index(): array {

        $response = $this->drugService->getDrugList();
        if (!$response['status']) {
            return [
                'status' => false,
                'message' => $response['errors']['type'],
                'data' => null,
            ];
        }

        return [
            'status' => true,
            'message' => '',
            'data' => $response['data'],
        ];

    }

    /**
     * Create the drug
     *
     * @param CreateDrugRequest $request
     * @return array
     */
    public function create(CreateDrugRequest $request): array {

        $response = $this->drugService->createDrug($request);

        if (!$response) {
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
            'data' => $response['data'],
        ];

    }

    /**
     * Find a drug
     *
     * @param ShowDrugRequest $request
     * @return array
     */
    public function show(ShowDrugRequest $request): array {

        $response = $this->drugService->findDrug($request);

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
            'data' => $response['data'],
        ];

    }
}
