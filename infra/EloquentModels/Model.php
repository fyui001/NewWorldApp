<?php

namespace Infra\EloquentModels;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{

    public function scopeWhereLike($query, string $attribute, string $keyword, int $position = 0)
    {
        $keyword = addcslashes($keyword, '\_%');

        $condition = [
                1  => "{$keyword}%",
                -1 => "%{$keyword}",
            ][$position] ?? "%{$keyword}%";

        return $query->where($attribute, 'LIKE', $condition);
    }

    public function scopeOrWhereLike($query, string $attribute, string $keyword, int $position = 0)
    {
        $keyword = addcslashes($keyword, '\_%');

        $condition = [
                1  => "{$keyword}%",
                -1 => "%{$keyword}",
            ][$position] ?? "%{$keyword}%";

        return $query->orWhere($attribute, 'LIKE', $condition);
    }

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

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

    /**
     * Common sort setting
     *
     * @param $query
     * @param $sortable
     * @param $orderBy
     * @param $sortOrder
     * @param $defaultKey
     * @return mixed
     */
    protected function commonSortSetting($query, $sortable, $orderBy, $sortOrder, $defaultKey)
    {
        foreach ($sortable as $key => $value) {
            if (is_int($key)) {
                if ($value === $orderBy) {
                    $sortOrder = (strtolower($sortOrder) != 'desc') ? 'asc' : 'desc';
                    return $query->orderBy($orderBy, $sortOrder);
                }
            }
        }
        return $query->orderBy($defaultKey);
    }
}
