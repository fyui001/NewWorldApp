<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Responder\ApiErrorResponder;
use App\Http\Requests\Api\Users\LoginUserRequest;
use App\Http\Requests\Api\Users\UserRegisterRequest;
use App\Services\Interfaces\UserServiceInterface;
use \Illuminate\Http\JsonResponse;

class UserController
{

    protected UserServiceInterface $userService;

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

        $response = $this->userService->login(
            $request->getUserId(),
            $request->getPasswordAsBaseValue(),
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

        return response()->json([
            'status' => true,
            'errors' => null,
            'message' => '',
            'data' => $response['data'],
        ]);
    }

    /**
     * ユーザー登録
     *
     * @param UserRegisterRequest $request
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $response = $this->userService->register(
            $request->getUserId(),
            $request->getUserHashedPassword(),
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

        return response()->json([
            'status' => true,
            'errors' => null,
            'message' => 'registered',
            'data' => $response['data'],
        ]);
    }
}
