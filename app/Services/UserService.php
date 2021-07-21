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
                    'key' => 'unauthorized',
                ],
                'data' => null,
            ];
        }

        $response = User::with('medicationHistories.drug')->where([
            'id' => $user->id,
        ])->first();

        return [
            'status' => true,
            'errors' => null,
            'data' => [
                'user' => $response,
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
            'is_registered' => true,
            'del_flg' => false,
        ];

        if (!Auth::guard('user')->attempt($credentials)) {
            return [
                'status' => false,
                'errors' => [
                    'key' => 'login_failure',
                ],
                'data' => null,
            ];
        }

        $user = Auth::guard('user')->user();
        $accessToken = auth('user')->claims([
            'guard' => 'user'
        ])->attempt($credentials);

        return [
            'status' => true,
            'errors' => null,
            'data' => [
                'user' => $user,
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
                    'key' => 'notfound',
                ],
                'data' => null,
            ];
        }

        if ($user->is_registered === true) {
            return [
                'status' => false,
                'errors' => [
                    'key' => 'duplicate_entry',
                ],
                'data' => null,
            ];
        }


        $requestData = [
            'password' => Hash::make($request->input('password')),
            'is_registered' => true,
        ];

        $response = $user->update($requestData);

        if (!$response) {
            return [
                'status' => false,
                'errors' => [
                    'key' => 'internal_server_error',
                ],
                'data' => null,
            ];
        }

        return [
            'status' => true,
            'errors' => null,
            'data' => null,
        ];

    }

}
