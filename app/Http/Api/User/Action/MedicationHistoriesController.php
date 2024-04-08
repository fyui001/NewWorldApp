<?php

declare(strict_types=1);

namespace App\Http\Api\User\Action;

use App\Http\Api\User\Request\MedicationIndexRequest;
use App\Services\UserService;
use Domain\Common\Paginator\Paginate;
use Illuminate\Http\JsonResponse;

class MedicationHistoriesController
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function index(MedicationIndexRequest $request): JsonResponse
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 20);

        $paginate = Paginate::make((int)$page, (int)$perPage);
        $user = $request->getUserDomain();

        $response = $this->userService->getMedicationHistoryPaginator($user, $paginate);

        return response()->json([
            'status' => true,
            'errors' => null,
            'message' => '',
            'data' => $response['data'],
        ], 200);
    }
}
