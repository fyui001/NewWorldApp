<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\Service as AppService;
use App\Services\Interfaces\UserServiceInterface;

class UserService extends AppService implements UserServiceInterface
{

    public function getUser(): array {

        $user = Auth::guard('user')->user();

        if (empty($user)) {
            return [];
        }

        $user->medicationHistories;

        return [
            'user' => $user,
        ];

    }

    public function login($request): array {

        $credentials = $request->only('user_id', 'password');
        $credentials += [
            'is_registered' => 1
        ];

        if (!Auth::guard('user')->attempt($credentials)) {
            return [];
        }

        $response = auth('user')->user();
        $accessToken = auth('user')->claims([
            'guard' => 'user'
        ])->attempt($credentials);

        $response->medicationHistories;

        return [
            'user' => $response,
            'access_token' => $accessToken,
        ];

    }

}
