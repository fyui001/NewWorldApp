<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Domain\Common\ExpiredAt;
use Domain\Common\Token;
use Domain\Exception\DuplicateEntryException;
use Domain\Exception\InvalidArgumentException;
use Domain\Exception\NotFoundException;
use Domain\User\DefinitiveRegisterToken\DefinitiveRegisterToken;
use Domain\User\DefinitiveRegisterToken\DefinitiveRegisterTokenRepository as DefinitiveRegisterTokenRepositoryInterface;
use Domain\User\Id;
use Infra\EloquentModels\UserDefinitiveRegisterToken as UserDefinitiveRegisterTokenModel;

class DefinitiveRegisterTokenRepository implements DefinitiveRegisterTokenRepositoryInterface
{
    public function getValidDefinitiveRegisterToken(Id $id): DefinitiveRegisterToken
    {
        $model = UserDefinitiveRegisterTokenModel::where(
            'expired_at', '>=' , ExpiredAt::now()->getSqlTimeStamp(),
        )->where([
            'user_id' => $id->getRawValue(),
            'is_verify' => false,
        ])->first();

        if (!$model) {
            throw new NotFoundException();
        }

        return $model->toDomain();
    }

    public function create(Id $id): DefinitiveRegisterToken
    {
        $model = UserDefinitiveRegisterTokenModel::where(
            'user_id', '=', $id->getRawValue(),
        )->where(
            'expired_at','>=', ExpiredAt::now()->getSqlTimeStamp(),
        )->get();

        if ($model->isNotEmpty()) {
            throw new DuplicateEntryException();
        }

        $model = new UserDefinitiveRegisterTokenModel;

        $model->user_id = $id->getRawValue();
        $model->token = Token::makeRandomCoStr(64)->getRawValue();
        $model->is_verify = false;
        $model->expired_at = ExpiredAt::makeExpiredAtTime()->getSqlTimeStamp();

        $model->save();

        return $model->toDomain();
    }

    public function tokenPutToUse(Token $token): DefinitiveRegisterToken
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

        return $model->toDomain();
    }
}
