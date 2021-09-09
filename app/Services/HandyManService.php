<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Service as AppService;
use App\Services\Interfaces\HandyManServiceInterface;
use Discord\Discord;

class HandyManService extends AppService implements HandyManServiceInterface
{
    protected Discord $discord;

    public function run(string $botToken): void {

        $this->discord = new Discord([
            'token' => $botToken,
        ]);

        $this->discord->run();

    }
}
