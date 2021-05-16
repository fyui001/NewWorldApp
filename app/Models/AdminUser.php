<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminUser extends Authenticatable
{
    use Notifiable;

    const ROLE_SYSTEM = 1;
    const ROLE_OPERATOR = 2;

    const STATUS_INVALID = 0;
    const STATUS_VALID = 1;

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

    /**
     * Get all roles.
     *
     * @return string[]
     */
    public static function roles(): array
    {
        return [
            self::ROLE_SYSTEM => 'システム管理者',
            self::ROLE_OPERATOR => '管理者',
        ];
    }

    /**
     *  Role_id to role_name.
     *
     * @param int $role
     * @return string
     */
    public static function getRoleText(int $role): string
    {
        $roles = self::roles();
        return !empty($roles[$role]) ? $roles[$role] : '';
    }

    /**
     * Get all statuses.
     *
     * @return array
     */
    public static function statuses(): array
    {
        return [
            self::STATUS_INVALID => '無効',
            self::STATUS_VALID => '有効',
        ];
    }

    /**
     *  Status_id to status_text.
     *
     * @param int $status
     * @return string
     */
    public static function getStatusText(int $status): string
    {
        $statuses = self::statuses();
        return !empty($statuses[$status]) ? $statuses[$status] : '';
    }
}
