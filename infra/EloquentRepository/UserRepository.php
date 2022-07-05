<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Domain\Drug\Drug;
use Domain\Drug\DrugId;
use Domain\Drug\DrugName;
use Domain\Drug\DrugUrl;
use Domain\Exception\NotFoundException;
use Domain\MedicationHistory\MedicationHistory;
use Domain\MedicationHistory\MedicationHistoryAmount;
use Domain\MedicationHistory\MedicationHistoryId;
use Domain\MedicationHistory\MedicationHistoryList;
use Domain\User\IconUrl;
use Domain\User\Id;
use Domain\User\User;
use Domain\User\UserHashedPassword;
use Domain\User\UserId;
use Domain\User\UserName;
use Domain\User\UserRepository as UserRepositoryInterface;
use Domain\User\UserStatus;
use Infra\EloquentModels\User as UserModel;

class UserRepository implements UserRepositoryInterface
{
    private const WITH_MODEL = [
        'medicationHistories.drug',
    ];

    public function get(Id $id): User
    {
        $model = UserModel::where([
            'id' => $id->getRawValue(),
        ])->first();

        if (!$model) {
            throw new NotFoundException();
        }

        return $model->toDomain();
    }

    public function getUserByUserId(UserId $userId): User
    {
        $model = UserModel::where([
            'user_id' => $userId->getRawValue(),
        ])->first();

        if (!$model) {
            throw new NotFoundException();
        }

        return $model->toDomain();
    }

    public function userRegister(
        Id $id,
        UserHashedPassword $password,
        UserStatus $userStatus
    ): bool {
        $model = UserModel::where([
            'id' => $id->getRawValue(),
        ])->first();

        return $model->update([
            'password' => $password->getRawValue(),
            'status' => $userStatus->getValue()->getRawValue(),
        ]);
    }
}
