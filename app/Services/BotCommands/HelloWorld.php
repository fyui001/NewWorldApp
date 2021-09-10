<?php

declare(strict_types=1);

namespace App\Services\BotCommands;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;

class HelloWorld
{
    protected string $commandName = 'hello';

    public function run(Discord $discord, Message $message, string $command, $args = null)
    {
        if ($this->commandName !== $command) {
            return false;
        }

        $bot = $discord->user;

        if ($message->author->user->id === $bot->id || $message->user->bot) {
            return 0;
        }
        $message->reply('Watching you');

        return true;
    }
}
