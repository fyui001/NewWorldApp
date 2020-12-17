<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Http\Requests\Users\LoginUserRequest;
use App\Http\Requests\Users\RegisterUserRequest;

interface UserServiceInterface {
    public function getUser(): array;
    public function login(LoginUserRequest $request): array;
    public function register(RegisterUserRequest $request): bool;
}
