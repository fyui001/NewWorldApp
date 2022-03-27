<?php

declare(strict_types=1);

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\User
 *
 * @property int $id id
 * @property int $user_id ユーザーID
 * @property string $name 名前
 * @property string $icon_url アイコンURL
 * @property string $password パスワード
 * @property string $access_token アクセストークン
 * @property bool $is_registered 登録フラグ
 * @property bool $del_flg 削除フラグ
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MedicationHistory[] $medicationHistories
 * @property-read int|null $medication_histories_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDelFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIconUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserId($value)
 * @mixin \Eloquent
 */
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

    protected $casts = [
        'is_registered' => 'boolean',
        'del_flg' => 'boolean',
    ];

    /**
     * @return HasMany
     */
    public function medicationHistories(): HasMany {

        return $this->hasMany('App\Models\MedicationHistory', 'user_id');

    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {

        return $this->getKey();

    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {

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
}
