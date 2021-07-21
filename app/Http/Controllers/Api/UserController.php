<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Requests\Users\LoginUserRequest;
use App\Http\Requests\Users\RegisterUserRequest;
use App\Services\Interfaces\UserServiceInterface;
use \Illuminate\Http\JsonResponse;

class UserController
{

    protected $userService;

    public function __construct(UserServiceInterface $userService) {;

        $this->userService = $userService;

    }

    /**
     * ユーザー情報取得
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {

        $response = $this->userService->getUser();

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
            'errors' => null,
            'message' => '',
            'data' => $response['data'],
        ], 200);

    }

    /**
     * ログイン
     *
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {

        $response = $this->userService->login($request);

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
            'errors' => null,
            'message' => '',
            'data' => $response['data'],
        ], 200);

    }

    /**
     * ユーザー登録
     *
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {

        $response = $this->userService->register($request);

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
            'errors' => null,
            'message' => 'registered',
            'data' => $response['data'],
        ], 200);

    }

}
