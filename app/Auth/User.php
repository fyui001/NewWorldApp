<?php

declare(strict_types=1);

namespace App\Auth;

use Domain\Base\BaseValue;
use Domain\User\User as UserDomain;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Hashing\Hasher;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User implements Authenticatable, JWTSubject
{
    public function __construct(
       private UserDomain $user,
    ) {
    }

    /**
     * @return UserDomain
     */
    public function getUser(): UserDomain
    {
        return $this->user;
    }

    /**
     * @param UserDomain $user
     */
    public function setUser(UserDomain $user): void
    {
        $this->user = $user;
    }

    public function getAuthIdentifier(): int
    {
        return $this->user->getId()->getRawValue();
    }

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthPassword(): string
    {
        return $this->user->getHashedPassword()->getRawValue();
    }

    public function getRememberToken()
    {
        // do noting
    }

    public function getRememberTokenName()
    {
        // do noting
    }

    public function setRememberToken($value)
    {
        // do noting
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getJWTIdentifier()
    {
        return $this->getAuthIdentifier();
    }

    public function checkPassword(Hasher $hasher, BaseValue $rawPassword): bool
    {
        if (!$this->user->hasHashedPassword()) {
            return false;
        }

        return $this->user->getHashedPassword()->check($hasher, $rawPassword);
    }
}
