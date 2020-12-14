<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Users\LoginUserRequest;
use App\Services\Interfaces\UserServiceInterface;

class UserController
{

    protected $userService;

    public function __construct(UserServiceInterface $userService) {;

        $this->userService = $userService;

    }

    public function show() {

        $users = $this->userService->getUser();

        if (!$users) {
            return [
                'status' => false,
                'msg' => 'unauthorized'
            ];
        }

        return [
            'status' => true,
            'data' => $users
        ];

    }

    public function login(LoginUserRequest $request) {

        $response = $this->userService->login($request);

        if (!$response) {
            return [
                'status' => false,
                'data' => [],
            ];
        }
        return [
            'status' => true,
            'data' => $response
        ];

    }

}
