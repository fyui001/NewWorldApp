<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\DiscordBot;

use Courage\CoString;
use Domain\DiscordBot\BotCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BotCommandTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testDisplayName()
    {
        $hello = BotCommand::HELLO;
        $registerDrug = BotCOmmand::REGISTER_DRUG;
        $medication = BotCommand::MEDICATION;

        $this->assertEquals(
            new CoString('hello'),
            $hello->displayName(),
        );
        $this->assertEquals(
            new CoString('薬物登録'),
            $registerDrug->displayName(),
        );
        $this->assertEquals(
            new CoString('のんだ'),
            $medication->displayName(),
        );
    }

    public function testMakeFromDisplayName()
    {
        $except = [
            'hello' => BotCommand::HELLO,
            '薬物登録' => BotCommand::REGISTER_DRUG,
            'のんだ' => BotCommand::MEDICATION,
        ];

        foreach ($except as $key => $value) {
            $this->assertEquals(
                $value,
                BotCommand::makeFromDisplayName($key),
            );
        }
    }
}
