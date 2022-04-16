<?php

declare(strict_types=1);

namespace Infra\EloquentModels;

use Domain\AdminUsers\AdminId;
use Domain\AdminUsers\AdminUserHashedPassword;
use Domain\AdminUsers\AdminUserId;
use Domain\AdminUsers\AdminUserName;
use Domain\AdminUsers\AdminUserRole;
use Domain\AdminUsers\AdminUserStatus;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Domain\AdminUsers\AdminUser as AdminUserDomain;
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
            new AdminUserHashedPassword(''),
            new AdminUserName($this->name),
            AdminUserRole::tryFrom($this->role),
            AdminUserStatus::tryFrom($this->status)
        );
    }
}
