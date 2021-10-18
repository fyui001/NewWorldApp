<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Service as AppService;
use App\Services\Interfaces\DiscordBotServiceInterface;
use Discord\Discord;
use Discord\Exceptions\IntentException;
use Discord\WebSockets\Intents;

class DiscordBotService extends AppService implements DiscordBotServiceInterface
{

    /**
     * Discord Instans
     *
     * @var Discord
     */
    protected Discord $discord;

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

        $this->discord->on('ready', function($discord) {

            $discord->on('message', function($message, $discord) {

                $commands = config('bot_commands');
                $commandPrefix = substr($message->content, 0, 1);
                $removedCommandPrefix = str_replace($this->commandPrefix, '', $message->content);

                if (!$this->commandPrefixChecker($commandPrefix)) {
                    return false;
                }

                $removedCommandPrefix = mb_convert_kana($removedCommandPrefix, 'rsa');
                $commandName = mb_strstr($removedCommandPrefix, ' ', true) ?: $removedCommandPrefix;

                if (mb_strstr($removedCommandPrefix, ' ', true) || mb_strstr($removedCommandPrefix, '　', true)) {
                    $commandContents = $this->argSplitter($removedCommandPrefix);
                    unset($commandContents[0]);
                    $commandArgs = array_values($commandContents);
                    foreach ($commands as $key => $value) {
                        $commandService = new $value['class'];
                        $commandService->run($discord, $message, $commandName, $commandArgs);
                    }
                } elseif (isset($commands[$commandName])) {
                    foreach ($commands as $key => $value) {
                        if ($key === $commandName) {
                            $commandService = new $value['class'];
                            $commandService->run($discord, $message, $commandName);
                        }
                    }
                }
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
}
