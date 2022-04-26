<?php

declare(strict_types=1);

namespace Infra\EloquentModels;

use Domain\Users\IconUrl;
use Domain\Users\User as UserDomain;
use Domain\Users\Id;
use Domain\Users\UserHashedPassword;
use Domain\Users\UserId;
use Domain\Users\UserName;
use Domain\Users\UserStatus;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements JWTSubject
{

    protected $table = 'users';

    protected $guarded = [
        'id',
        'user_id',
    ];

    protected $hidden = [
        'password',
    ];


    /**
     * @return HasMany
     */
    public function medicationHistories(): HasMany
    {
        return $this->hasMany('Infra\EloquentModels\MedicationHistory', 'user_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d: H:i:s');
    }

    public function toDomain(): UserDomain
    {
        return new UserDomain(
            new Id((int)$this->id),
            new UserId($this->user_id),
            new UserName($this->name),
            new IconUrl($this->icon_url),
            UserStatus::tryFrom((int)$this->status)
        );
    }
}
