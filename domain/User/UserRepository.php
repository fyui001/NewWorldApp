<?php

declare(strict_types=1);

namespace Domain\User;

use App\DataTransfer\User\UserAndMedicationHistoryDetailList;

interface UserRepository
{
    public function getUserById(Id $id): User;
    public function getUserByUserId(UserId $userId): User;
    public function userRegister(
        Id $id,
        UserHashedPassword $password,
        UserStatus $userStatus
    ): bool;
}
