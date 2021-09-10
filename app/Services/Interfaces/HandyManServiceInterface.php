<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

interface HandyManServiceInterface
{
    public function run(string $botToken): void;
    public function commandPrefixChecker(string $commandPrefix): bool;
    public function argSplitter(string $commandContents): array;
}
