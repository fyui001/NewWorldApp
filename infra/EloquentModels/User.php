<?php

declare(strict_types=1);

namespace Infra\EloquentModels;

use Domain\Common\HashedPassword;
use Domain\User\IconUrl;
use Domain\User\User as UserDomain;
use Domain\User\Id;
use Domain\User\UserId;
use Domain\User\UserName;
use Domain\User\UserStatus;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
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
            $this->password ? new HashedPassword($this->password) : null,
            new IconUrl($this->icon_url),
            UserStatus::tryFrom((int)$this->status)
        );
    }
}
