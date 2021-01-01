<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Service as AppService;
use App\Services\Interfaces\UserServiceInterface;
use App\Http\Requests\Users\LoginUserRequest;
use App\Http\Requests\Users\RegisterUserRequest;

class UserService extends AppService implements UserServiceInterface
{

    /**
     * ユーザー情報取得
     *
     * @return array
     */
    public function getUser(): array {

        $user = Auth::guard('user')->user();

        if (empty($user)) {
            return [
                'status' => false,
                'errors' => [
                    'type' => 'unauthorized',
                ],
            ];
        }

        $user->medicationHistories;

        return [
            'status' => true,
            'data' => [
                'user' => $user,
            ],
        ];

    }

    /**
     * ログイン
     *
     * @param LoginUserRequest $request
     * @return array
     */
    public function login(LoginUserRequest $request): array {

        $credentials = $request->only('user_id', 'password');
        $credentials += [
            'is_registered' => 1,
            'del_flg' => 0,
        ];

        if (!Auth::guard('user')->attempt($credentials)) {
            return [
                'status' => false,
                'errors' => [
                    'type' => 'unauthorized',
                ],
            ];
        }

        $response = auth('user')->user();
        $accessToken = auth('user')->claims([
            'guard' => 'user'
        ])->attempt($credentials);

        $response->medicationHistories;

        return [
            'status' => true,
            'data' => [
                'user' => $response,
                'access_token' => $accessToken,
            ],
        ];

    }

    /**
     * 登録
     *
     * @param RegisterUserRequest $request
     * @return array
     */
    public function register(RegisterUserRequest $request): array {

        $user = User::where(['user_id' => $request->input('user_id')])->first();

        if (empty($user)) {
            return [
                'status' => false,
                'errors' => [
                    'type' => 'User is not found',
                ]
            ];
        }

        if ($user->is_registered === 1) {
            return [
                'status' => false,
                'errors' => [
                    'type' => 'Already registered',
                ]
            ];
        }


        $requestData = [
            'password' => Hash::make($request->input('password')),
            'is_registered' => 1,
        ];

        $response = $user->update($requestData);

        if (!$response) {
            return [
                'status' => false,
                'errors' => [
                    'type' => 'Failed to register',
                ],
            ];
        }

        return [
            'status' => true,
        ];

    }

}
