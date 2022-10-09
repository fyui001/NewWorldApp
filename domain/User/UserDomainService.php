<?php

declare(strict_types=1);

namespace Domain\User;

use Domain\Common\RawPassword;
use Illuminate\Contracts\Hashing\Hasher;

class UserDomainService
{

    public function __construct(
        private UserRepository $userRepository,
        private Hasher $hasher,
    ) {
    }

    public function getUserById(Id $id): User
    {
        return $this->userRepository->get($id);
    }

    public function getUserByUserId(UserId $userId): User
    {
        return $this->userRepository->getUserByUserId($userId);
    }

    public function userRegister(
        Id $id,
        RawPassword $password,
        UserStatus $userStatus,
    ): bool {
        return $this->userRepository->userRegister(
            $id,
            $password->hash($this->hasher),
            $userStatus,
        );
    }
}
