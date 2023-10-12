<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace Infra\EloquentModels{
/**
 * Infra\EloquentModels\AdminUser
 *
 * @property int $id id
 * @property string $user_id 管理者ID
 * @property string $password パスワード
 * @property string $name 名前
 * @property int $role ロール
 * @property bool $status ステータス
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUser query()
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

namespace Infra\EloquentModels{
/**
 * Infra\EloquentModels\Drug
 *
 * @property int $id
 * @property string $drug_name
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Infra\EloquentModels\MedicationHistory[] $medicationHistories
 * @property-read int|null $medication_histories_count
 * @method static \Illuminate\Database\Eloquent\Builder|Drug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Drug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model orWhereLike(string $attribute, string $keyword, int $position = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|Drug query()
 * @method static \Illuminate\Database\Eloquent\Builder|Drug sortSetting(string $orderBy, string $sortOrder, string $defaultKey = 'id')
 * @method static \Illuminate\Database\Eloquent\Builder|Drug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Drug whereDrugName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Drug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereLike(string $attribute, string $keyword, int $position = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|Drug whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Drug whereUrl($value)
 */
	class Drug extends \Eloquent {}
}

namespace Infra\EloquentModels{
/**
 * Infra\EloquentModels\MedicationHistory
 *
 * @property int $id
 * @property int $user_id
 * @property int $drug_id
 * @property string $amount 服薬量
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Infra\EloquentModels\Drug $drug
 * @property-read \Infra\EloquentModels\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|MedicationHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MedicationHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model orWhereLike(string $attribute, string $keyword, int $position = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|MedicationHistory query()
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

namespace Infra\EloquentModels{
/**
 * Infra\EloquentModels\User
 *
 * @property int $id id
 * @property int $user_id ユーザーID
 * @property string $name 名前
 * @property string $icon_url アイコンURL
 * @property string $password パスワード
 * @property int $status ステータス
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Infra\EloquentModels\MedicationHistory[] $medicationHistories
 * @property-read int|null $medication_histories_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIconUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserId($value)
 */
	class User extends \Eloquent {}
}

namespace Infra\EloquentModels{
/**
 * Infra\EloquentModels\UserDefinitiveRegisterToken
 *
 * @property int $id id
 * @property int $user_id
 * @property string $token トークン
 * @property int $is_verify 認証したか
 * @property string $expired_at 有効期限
 * @property \Illuminate\Support\Carbon|null $created_at 作成日時
 * @property \Illuminate\Support\Carbon|null $updated_at 更新日時
 * @method static \Illuminate\Database\Eloquent\Builder|UserDefinitiveRegisterToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDefinitiveRegisterToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model orWhereLike(string $attribute, string $keyword, int $position = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDefinitiveRegisterToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDefinitiveRegisterToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDefinitiveRegisterToken whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDefinitiveRegisterToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDefinitiveRegisterToken whereIsVerify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Model whereLike(string $attribute, string $keyword, int $position = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDefinitiveRegisterToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDefinitiveRegisterToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDefinitiveRegisterToken whereUserId($value)
 */
	class UserDefinitiveRegisterToken extends \Eloquent {}
}

