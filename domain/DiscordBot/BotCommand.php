<?php

declare(strict_types=1);

namespace Domain\DiscordBot;

use Domain\Common\RawString;
use Domain\DiscordBot\CommandArgument\MedicationCommandArgument;
use Domain\DiscordBot\CommandArgument\RegisterDrugCommandArgument;
use Domain\Exception\InvalidArgumentException;

enum BotCommand: string
{
    case HELLO = 'hello';
    case REGISTER_DRUG = 'registerDrug';
    case MEDICATION = 'medication';

    public function displayName(): RawString
    {
        return match($this) {
            self::HELLO => new RawString('hello'),
            self::REGISTER_DRUG => new RawString('薬物登録'),
            self::MEDICATION => new RawString('のんだ'),
        };
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function makeFromDisplayName(string $displayName): self
    {
        try {
            $value = match($displayName) {
                'hello' => self::HELLO,
                '薬物登録' => self::REGISTER_DRUG,
                'のんだ' => self::MEDICATION
            };
        } catch(\UnhandledMatchError $e) {
            throw new InvalidArgumentException();
        }

        return $value;
    }

    public function getCommandArgumentClass(array $commandArgs)
    {
        return match($this) {
            self::REGISTER_DRUG => new RegisterDrugCommandArgument($commandArgs),
            self::MEDICATION => new MedicationCommandArgument($commandArgs),
        };
    }
}
