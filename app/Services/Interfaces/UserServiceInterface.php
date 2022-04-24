<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Http\Requests\Api\Users\LoginUserRequest;
use App\Http\Requests\Api\Users\UserRegisterRequest;

interface UserServiceInterface {
    public function getUser(): array;
    public function login(LoginUserRequest $request): array;
    public function register(UserRegisterRequest $request): array;
}
