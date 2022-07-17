<?php

declare(strict_types=1);

namespace Domain\Common;

enum OrderKey: string
{
    case ASC = 'asc';
    case DESC = 'desc';

    public function displayName(): RawString
    {
        return match($this) {
            self::ASC => new RawString('昇順'),
            self::DESC => new RawString('降順'),
        };
    }

    public function getValue(): RawString
    {
        return new RawString($this->value);
    }
}
