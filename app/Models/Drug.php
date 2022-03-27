<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Model as AppModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kyslik\ColumnSortable\Sortable;

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
 * @mixin \Eloquent
 */
class Drug extends AppModel
{

    use Sortable;

    protected $table = 'drugs';

    protected $guarded = [
        'id',
    ];

    public static array $sortable = [
        'id',
        'drug_name',
    ];

    /**
     * @return HasMany
     */
    public function medicationHistories(): HasMany {

        return $this->hasMany('App\Models\MedicationHistory', 'drug_id');

    }

    /**
     * Sort
     *
     * @param $query
     * @param $orderBy
     * @param $sortOrder
     * @param string $defaultKey
     * @return mixed
     */
    public function scopeSortSetting($query, $orderBy, $sortOrder, $defaultKey = 'id')
    {
        return AppModel::commonSortSetting($query, self::$sortable, $orderBy, $sortOrder, $defaultKey);
    }

}
