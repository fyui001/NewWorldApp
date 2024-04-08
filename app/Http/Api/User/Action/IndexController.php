<?php

declare(strict_types=1);

namespace App\Http\Api\User\Action;

use App\Http\Api\User\Request\LoginUserRequest;
use App\Http\Api\User\Request\UserDefinitiveRegister;
use App\Http\Api\User\Request\UserDetailRequest;
use App\Http\Api\User\Request\UserRegisterRequest;
use App\Http\Api\User\Responder\UserLoginResponder;
use App\Http\Responder\ApiErrorResponder;
use App\Http\Responder\EmptyResponder;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class IndexController
{

    public function __construct
    (
        private readonly UserService $userService
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
     * @return UserLoginResponder|EmptyResponder
     */
    public function login(LoginUserRequest $request): ApiErrorResponder|EmptyResponder
    {

        $credentials = [
            'user_id' => $request->getUserId()->getRawValue(),
            'password' => $request->getPasswordAsBaseValue()->getRawValue(),
        ];

        if (!Auth::guard('api')->attempt($credentials)) {
            return new ApiErrorResponder('login_failure');
        }

        return new EmptyResponder();
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
