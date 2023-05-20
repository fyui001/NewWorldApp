<?php

declare(strict_types=1);

namespace App\Http\Api\User\Action;

use App\Http\Api\User\Request\LoginUserRequest;
use App\Http\Api\User\Request\UserDefinitiveRegister;
use App\Http\Api\User\Request\UserDetailRequest;
use App\Http\Api\User\Request\UserRegisterRequest;
use App\Http\Api\User\Responder\UserLoginResponder;
use App\Http\Responder\ApiErrorResponder;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\JsonResponse;

class IndexController
{

    public function __construct
    (
        private UserServiceInterface $userService
    ) {
    }

    /**
     * ユーザー情報取得
     *
     * @param UserDetailRequest $request
     * @return JsonResponse|ApiErrorResponder
     */
    public function show(UserDetailRequest $request): JsonResponse|ApiErrorResponder
    {
        $user = $request->loginUser();

        if (!$user) {
            return new ApiErrorResponder('unauthorized');
        }

        $response = $this->userService->getUserDetail($user);

        if (!$response['status']) {
            return new ApiErrorResponder($response['errors']['key']);
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
     * @return UserLoginResponder|ApiErrorResponder
     */
    public function login(LoginUserRequest $request): ApiErrorResponder|UserLoginResponder
    {

        $response = $this->userService->login(
            $request->getUserId(),
            $request->getPasswordAsBaseValue(),
        );

        if (!$response['status']) {
            return new ApiErrorResponder($response['errors']['key']);
        }

        return new UserLoginResponder($response['data']['user']);
    }

    /**
     * ユーザー登録
     *
     * @param UserRegisterRequest $request
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request): JsonResponse|ApiErrorResponder
    {
        $response = $this->userService->register(
            $request->getUserId(),
            $request->getUserRawPassword(),
        );

        if (!$response['status']) {
            return new ApiErrorResponder($response['errors']['key']);
        }

        return response()->json([
            'status' => true,
            'errors' => null,
            'message' => 'password registered',
            'data' => $response['data'],
        ]);
    }

    public function definitiveRegister(UserDefinitiveRegister $request): JsonResponse|ApiErrorResponder
    {
        $definitiveRegisterToken = $request->getToken();

        $response = $this->userService->definitiveRegister($definitiveRegisterToken);

        if (!$response['status']) {
            return new ApiErrorResponder($response['errors']['key']);
        }

        return response()->json([
            'status' => true,
            'errors' => null,
            'message' => 'success definitive register',
            'data' => null,
        ], 200);
    }
}
