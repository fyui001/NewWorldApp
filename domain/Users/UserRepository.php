<?php

declare(strict_types=1);

namespace Domain\Users;

interface UserRepository
{
    public function getUserByIdWithMedicationHistories(Id $id): UserAndMedicationHistory;
    public function getUserByUserId(UserId $userId): User;
    public function userRegister(
        Id $id,
        UserHashedPassword $password,
        UserStatus $userStatus
    ): bool;
}
