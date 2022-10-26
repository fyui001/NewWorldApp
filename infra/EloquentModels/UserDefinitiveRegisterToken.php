<?php

declare(strict_types=1);

namespace Infra\EloquentModels;

use Domain\User\Id as UserId;
use Infra\EloquentModels\Model as AppModel;

class UserDefinitiveRegisterToken extends AppModel
{
    protected $table = 'user_definitive_register_tokens';

    protected $guarded = [
        'id',
    ];

    public function getUserId(): UserId
    {
        return new UserId((int)$this->user_id);
    }
}
