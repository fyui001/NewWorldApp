<?php

declare(strict_types=1);


namespace Domain\Common;

use Courage\CoString;

enum OrderKey: string
{
    case ASC = 'asc';
    case DESC = 'desc';

    public function displayName(): CoString
    {
        return match($this) {
            self::ASC => new CoString('昇順'),
            self::DESC => new CoString('降順'),
        };
    }

    public function getValue(): CoString
    {
        return new CoString($this->value);
    }
}
