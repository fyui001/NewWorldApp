<?php

declare(strict_types=1);

namespace App\Libs;

trait EloquentQueryBuilder
{
    protected function whereLike(string $attribute, string $keyword, int $position = 0)
    {
        $keyword = addcslashes($keyword, '\_%');

        $condition = [
                1  => $keyword . '%',
                -1 => '%' . $keyword,
            ][$position] ?? '%' . $keyword . '%';

        return $this->where($attribute, 'LIKE', $condition);
    }

    protected function orWhereLike(string $attribute, string $keyword, int $position = 0)
    {
        $keyword = addcslashes($keyword, '\_%');

        $condition = [
                1  => $keyword . '%',
                -1 => '%' . $keyword,
            ][$position] ?? '%' . $keyword . '%';

        return $this->where($attribute, 'LIKE', $condition);
    }
}
