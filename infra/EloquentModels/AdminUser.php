<?php

declare(strict_types=1);

namespace Infra\EloquentModels;

use Domain\AdminUser\AdminId;
use Domain\AdminUser\AdminUserHashedPassword;
use Domain\AdminUser\AdminUserId;
use Domain\AdminUser\AdminUserName;
use Domain\AdminUser\AdminUserRole;
use Domain\AdminUser\AdminUserStatus;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Domain\AdminUser\AdminUser as AdminUserDomain;

class AdminUser extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'admin_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function toDomain(): AdminUserDomain
    {
        return new AdminUserDomain(
            new AdminId($this->id),
            new AdminUserId($this->user_id),
            new AdminUserHashedPassword($this->password),
            new AdminUserName($this->name),
            AdminUserRole::tryFrom((int)$this->role),
            AdminUserStatus::tryFrom((int)$this->status)
        );
    }
}
