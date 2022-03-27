<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\AdminUser
 *
 * @property int $id id
 * @property string $user_id 管理者ID
 * @property string $password パスワード
 * @property string $name 名前
 * @property int $role ロール
 * @property bool $status ステータス
 * @property string $api_token APIトークン
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser whereUserId($value)
 * @mixin \Eloquent
 */
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
