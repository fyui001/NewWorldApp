<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Domain\Common\ExpiredAt;
use Domain\Common\HashedPassword;
use Domain\Common\Token;
use Domain\User\DefinitiveRegisterToken\DefinitiveRegisterToken;
use Domain\Exception\DuplicateEntryException;
use Domain\Exception\InvalidArgumentException;
use Domain\Exception\NotFoundException;
use Domain\User\Id;
use Domain\User\User;
use Domain\User\UserId;
use Domain\User\UserRepository as UserRepositoryInterface;
use Domain\User\UserStatus;
use Infra\EloquentModels\User as UserModel;
use Infra\EloquentModels\UserDefinitiveRegisterToken as UserDefinitiveRegisterTokenModel;

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
        UserStatus $userStatus
    ): bool {
        $model = UserModel::where([
            'id' => $id->getRawValue(),
        ])->first();

        $definitiveRegisterTokenModel = UserDefinitiveRegisterTokenModel::where(
            'user_id', '=', $id->getRawValue()
        )->where(
            'expired_at','>=', ExpiredAt::now()->getSqlTimeStamp()
        )->get();

        if ($definitiveRegisterTokenModel->isNotEmpty()) {
            throw new DuplicateEntryException();
        }

        $definitiveRegisterTokenModel = new UserDefinitiveRegisterTokenModel;

        $definitiveRegisterTokenModel->user_id = $id->getRawValue();
        $definitiveRegisterTokenModel->token = Token::makeRandomCoStr(64);
        $definitiveRegisterTokenModel->is_verify = false;
        $definitiveRegisterTokenModel->expired_at = ExpiredAt::makeExpiredAtTime()->getSqlTimeStamp();

        $definitiveRegisterTokenModel->save();

        return $model->update([
            'password' => $password->getRawValue(),
        ]);
    }

    public function definitiveRegister(Token $token): bool
    {
        $model = UserDefinitiveRegisterTokenModel::where([
            'token' => $token->getRawValue()
        ])->where(
            'expired_at', '>=' , ExpiredAt::now()->getSqlTimeStamp()
        )->where([
            'is_verify' => false
        ])->first();

        if (!$model) {
            throw new InvalidArgumentException();
        }

        $model->is_verify = true;
        $model->save();

        $definitiveRegisterToken = $model->toDomain();

        $userModel = UserModel::where(['id' => $definitiveRegisterToken->getUserId()->getRawValue()])->first();

        return $userModel->update([
            'status' => UserStatus::STATUS_VALID->getValue()->getRawValue()
        ]);
    }

    public function getDefinitiveRegisterToken(Id $id): DefinitiveRegisterToken
    {
        $model = UserDefinitiveRegisterTokenModel::where(
            'expired_at', '>=' , ExpiredAt::now()->getSqlTimeStamp(),
        )->where([
            'user_id' => $id->getRawValue(),
            'is_verify' => false,
        ])->first();

        return $model->toDomain();
    }
}
