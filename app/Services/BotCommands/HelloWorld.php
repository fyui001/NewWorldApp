<?php

declare(strict_types=1);

namespace App\Services\BotCommands;

use Discord\Discord;
use Discord\Parts\Channel\Message;

class HelloWorld
{
    protected string $commandName = 'hello';

    public function run(Discord $discord, Message $message, string $command, $args = []): bool
    {
        if ($this->commandName !== $command) {
            return false;
        }

        $bot = $discord->user;

        if ($message->author->user->id === $bot->id || $message->user->bot) {
            return false;
        }

        $message->reply('Watching you');

        return true;
    }
}
