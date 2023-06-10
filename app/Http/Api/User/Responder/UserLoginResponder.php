<?php

declare(strict_types=1);

namespace App\Http\Api\User\Responder;

use App\Http\Responder\BaseResponder;
use Domain\User\User;

class UserLoginResponder extends BaseResponder
{
    private array $user;

    public function  __construct(User $user)
    {
        $this->user = $user->toArray();
    }
}
