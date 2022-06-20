<?php

declare(strict_types=1);

namespace Infra\Discord;

use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;

class MessageSender
{
    public function __construct(private Message $message)
    {
    }

    public function sendEmbed(Embed $embed): void
    {
        try {
            $this->message->channel->sendEmbed($embed);
        } catch (\Exception $e) {
            $this->message->channel->sendMessage($e->getMessage());
        }
    }
}
