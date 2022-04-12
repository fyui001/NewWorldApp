<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
 */
	class AdminUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Drug
 *
 * @property int $id
 * @property string $drug_name
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MedicationHistory[] $medicationHistories
 * @property-read int|null $medication_histories_count
 * @method static \Illuminate\Database\Eloquent\Builder|Drug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Drug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model orWhereLike(string $attribute, string $keyword, int $position = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|Drug query()
 * @method static \Illuminate\Database\Eloquent\Builder|Drug sortSetting(string $orderBy, string $sortOrder, string $defaultKey = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Drug sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Drug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Drug whereDrugName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Drug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereLike(string $attribute, string $keyword, int $position = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|Drug whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Drug whereUrl($value)
 */
	class Drug extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MedicationHistory
 *
 * @property int $id
 * @property int $user_id
 * @property int $drug_id
 * @property string $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Drug|null $drug
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|MedicationHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicationHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model orWhereLike(string $attribute, string $keyword, int $position = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicationHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicationHistory sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicationHistory whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicationHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicationHistory whereDrugId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicationHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereLike(string $attribute, string $keyword, int $position = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicationHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicationHistory whereUserId($value)
 */
	class MedicationHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Model
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model orWhereLike(string $attribute, string $keyword, int $position = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|Model query()
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereLike(string $attribute, string $keyword, int $position = 0)
 */
	class Model extends \Eloquent {}
}

namespace App\Models{
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
 */
	class User extends \Eloquent implements \Tymon\JWTAuth\Contracts\JWTSubject {}
}

