<?php

declare(strict_types=1);

namespace Infra\EloquentModels;

use Domain\Drug\Drug as DrugDomain;
use Domain\Drug\DrugId;
use Domain\Drug\DrugName;
use Domain\Drug\DrugUrl;
use Illuminate\Database\Eloquent\Builder;
use Infra\EloquentModels\Model as AppModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Drug extends AppModel
{

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
     * @param Builder $query
     * @param string $orderBy
     * @param string $sortOrder
     * @param string $defaultKey
     * @return mixed
     */
    public static function scopeSortSetting(
        Builder $query,
        string $orderBy,
        string $sortOrder,
        string $defaultKey = 'id',
    ): Builder {
        return AppModel::commonSortSetting(
            $query,
            self::$sortable,
            $orderBy,
            $sortOrder,
            $defaultKey
        );
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
