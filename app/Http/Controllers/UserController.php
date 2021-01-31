<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Users\LoginUserRequest;
use App\Http\Requests\Users\RegisterUserRequest;
use App\Services\Interfaces\UserServiceInterface;

class UserController
{

    protected $userService;

    public function __construct(UserServiceInterface $userService) {;

        $this->userService = $userService;

    }

    /**
     * ユーザー情報取得
     *
     * @return array
     */
    public function show() {

        $users = $this->userService->getUser();

        if (!$users['status']) {
            return [
                'status' => false,
                'message' => $users['errors']['type'],
                'data' => null,
            ];
        }

        return [
            'status' => true,
            'message' => '',
            'data' => $users['data'],
        ];

    }

    /**
     * ログイン
     *
     * @param LoginUserRequest $request
     * @return array
     */
    public function login(LoginUserRequest $request) {

        $response = $this->userService->login($request);

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
            'data' => $response['data']
        ];


    }

    /**
     * ユーザー登録
     *
     * @param RegisterUserRequest $request
     * @return array
     */
    public function register(RegisterUserRequest $request) {

        $response = $this->userService->register($request);

        if (!$response['status']) {
            return [
                'status' => false,
                'message' => $response['errors']['type'],
                'data' => null,
            ];
        }

        return [
            'status' => true,
            'message' => 'registered',
            'data' => null,
        ];

    }

}
