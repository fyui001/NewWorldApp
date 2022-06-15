<?php

declare(strict_types=1);

namespace Domain\DiscordBot;

use Courage\CoString;
use Domain\Exception\InvalidArgumentException;

enum BotCommand: string
{
    case HELLO = 'hello';
    case REGISTER_DRUG = 'registerDrug';

    public function displayName(): CoString
    {
        return match($this) {
            self::HELLO => new CoString('hello'),
            self::REGISTER_DRUG => new CoString('薬物登録'),
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
            };
        } catch(\UnhandledMatchError $e) {
            throw new InvalidArgumentException();
        }

        return $value;
    }
}
