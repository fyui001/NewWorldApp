<?php

declare(strict_types=1);

namespace Domain\User;

use App\DataTransfer\User\UserMedicationHistoryDetailList;

interface UserRepository
{
    public function get(Id $id): User;
    public function getUserByUserId(UserId $userId): User;
    public function userRegister(
        Id $id,
        UserHashedPassword $password,
        UserStatus $userStatus
    ): bool;
}
