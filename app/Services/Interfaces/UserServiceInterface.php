<?php

declare(strict_types=1);

namespace App\Services\Interfaces;


use App\Http\Requests\Api\Users\UserRegisterRequest;
use Domain\Base\BaseValue;
use Domain\User\UserId;
use Domain\User\UserStatus;

interface UserServiceInterface {
    public function getUser(): array;
    public function login(UserId $userId, BaseValue $rawPassword): array;
    public function register(UserRegisterRequest $request): array;
}
