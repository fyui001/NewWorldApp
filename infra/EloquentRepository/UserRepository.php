<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Domain\Common\HashedPassword;
use Domain\Exception\NotFoundException;
use Domain\User\Id;
use Domain\User\User;
use Domain\User\UserId;
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
        HashedPassword $password,
    ): bool {
        $model = UserModel::where([
            'id' => $id->getRawValue(),
        ])->first();

        return $model->update([
            'password' => $password->getRawValue(),
        ]);
    }

    public function definitiveRegister(Id $id): bool
    {
        $userModel = UserModel::where(['id' => $id->getRawValue()])->first();

        return $userModel->update([
            'status' => UserStatus::STATUS_VALID->getValue()->getRawValue()
        ]);
    }
}
