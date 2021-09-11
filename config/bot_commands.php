<?php

use App\Services\BotCommands;

return [
    'hello' => [
        'class' => BotCommands\HelloWorld::class,
    ],
    '薬物登録' => [
        'class' => BotCommands\RegisterDrug::class,
    ],
];
