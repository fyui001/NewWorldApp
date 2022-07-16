<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Service as AppService;
use App\Services\Interfaces\DiscordBotServiceInterface;
use Discord\Discord;
use Discord\Exceptions\IntentException;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Intents;
use Domain\DiscordBot\BotCommand;
use Domain\DiscordBot\DiscordBotDomainService;

class DiscordBotService extends AppService implements DiscordBotServiceInterface
{
    public function __construct(
      private DiscordBotDomainService $discordBotDomainService,
    ) {
    }

    /**
     * Discord Instants
     *
     * @var Discord
     */
    protected Discord $discord;
    protected  Message $message;

    /**
     * This Command Prefix
     *
     * @var string
     */
    protected string $commandPrefix = '!';


    /**
     * Starting run a discord bot
     *
     * @param string $botToken
     * @throws IntentException
     */
    public function run(string $botToken): void
    {
        $this->discord = new Discord([
            'token' => $botToken,
            'loadAllMembers' => true,
            'intents' => Intents::getDefaultIntents() | Intents::GUILD_MEMBERS,
        ]);

        $this->discord->on('ready', function(Discord $discord) {

            $discord->on('message', function(Message $message) {
                $this->message = $message;
                $commandPrefix = substr($this->message->content, 0, 1);
                $removedCommandPrefix = str_replace($this->commandPrefix, '', $this->message->content);
                $commandContents = [];

                if (!$this->commandPrefixChecker($commandPrefix) || !$this->commandCheck($this->message)) {
                    return false;
                }

                $removedCommandPrefix = mb_convert_kana($removedCommandPrefix, 'rsa');
                $commandName = mb_strstr($removedCommandPrefix, ' ', true) ?: $removedCommandPrefix;
                $botCommandName = BotCommand::makeFromDisplayName($commandName)->getValue();

                if (mb_strstr($removedCommandPrefix, ' ', true) || mb_strstr($removedCommandPrefix, '　', true)) {
                    $commandContents += $this->argSplitter($removedCommandPrefix);
                    unset($commandContents[0]);
                    $commandArgs = array_values($commandContents);
                    $commandArgs = BotCommand::makeFromDisplayName($commandName)->getCommandArgumentClass($commandArgs);
                    $this->discordBotDomainService->$botCommandName($commandArgs, $this->discord, $this->message);
                    return true;
                }

                $this->discordBotDomainService->$botCommandName($this->discord, $this->message);

                return true;
            });
        });

        $this->discord->run();
    }

    /**
     * Command prefix check
     *
     * @param string $commandPrefix
     * @return bool
     */
    public function commandPrefixChecker(string $commandPrefix): bool
    {
        return $this->commandPrefix === $commandPrefix;
    }


    /**
     * Split the message and get dhe arguments
     *
     * @param string $commandContents
     * @return array
     */
    public function argSplitter(string $commandContents): array
    {
        return explode(' ', $commandContents);
    }

    private function commandCheck(Message $message): bool
    {
        $bot = $this->discord->user;

        if (
            $message->author->user->id === $bot->id
            || $message->user->bot
        ) {
            return false;
        }

        return true;
    }
}
