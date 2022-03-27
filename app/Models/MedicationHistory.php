<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Model as AppModel;
use Kyslik\ColumnSortable\Sortable;

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
 * @mixin \Eloquent
 */
class MedicationHistory extends AppModel
{

    use Sortable;

    protected $table = 'medication_histories';

    protected $guarded = [
        'id',
    ];

    public $sortable = [
        'id',
        'name',
        'drug_name',
    ];

    public function user() {

        return $this->belongsTo('App\Models\User', 'user_id');

    }

    public function drug() {

        return $this->belongsTo('App\Models\Drug', 'drug_id');

    }

}
