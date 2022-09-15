<?php

declare(strict_types=1);

namespace Domain\Base;

use Courage\CoList;

abstract class BaseHashMap extends CoList
{
    public function __construct(array $value)
    {
        parent::__construct($value);
    }

    public function get(string $key)
    {
        if (!array_key_exists($key, $this->value)) {
            return null;
        }

        return $this->value[$key];
    }

    public function set(string $key, $value): void
    {
        $this->value[$key] = $value;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->value) && isset($this->value[$key]);
    }
}
