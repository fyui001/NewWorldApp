<?php

declare(strict_types=1);

namespace Infra\EloquentModels;

use Domain\Common\ExpiredAt;
use Domain\Common\Token;
use Domain\User\Id as UserId;
use Domain\User\DefinitiveRegisterToken\DefinitiveRegisterToken;
use Infra\EloquentModels\Model as AppModel;

class UserDefinitiveRegisterToken extends AppModel
{
    protected $table = 'user_definitive_register_tokens';

    protected $guarded = [
        'id',
    ];

    public function toDomain(): DefinitiveRegisterToken
    {
        return new DefinitiveRegisterToken(
          new UserId((int)$this->user_id),
            new Token($this->token),
            ExpiredAt::forStringTime((string)$this->expired_at),
        );
    }
}
