<?php

declare(strict_types=1);

namespace Infra\EloquentModels;

use Domain\Drugs\Drug as DrugDomain;
use Domain\Drugs\DrugId;
use Domain\Drugs\DrugName;
use Domain\Drugs\DrugUrl;
use Infra\EloquentModels\Model as AppModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kyslik\ColumnSortable\Sortable;

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
    public function medicationHistories(): HasMany
    {
        return $this->hasMany('Infra\EloquentModels\MedicationHistory', 'drug_id');
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
    public function scopeSortSetting($query, $orderBy, $sortOrder, string $defaultKey = 'id'): mixed
    {
        return AppModel::commonSortSetting($query, self::$sortable, $orderBy, $sortOrder, $defaultKey);
    }

    public function toDomain(): DrugDomain
    {
        return new DrugDomain(
            new DrugId($this->id),
            new DrugName($this->drug_name),
            new DrugUrl($this->url)
        );
    }

}
