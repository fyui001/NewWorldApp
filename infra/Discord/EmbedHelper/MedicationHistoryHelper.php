<?php

declare(strict_types=1);

namespace Infra\Discord\EmbedHelper;

use Carbon\Carbon;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;
use Domain\MedicationHistory\MedicationHistory;

class MedicationHistoryHelper
{
    private string $title = 'のんだ';

    public function __construct(private Discord $discord, private Message $message)
    {
    }

    public function toMedicationHistoryCreatedEmbed(MedicationHistory $medicationHistory): Embed
    {
        $userAvatar = $this->message->user->getAvatarAttribute('png');
        $botAvatar = $this->discord->user->getAvatarAttribute('png');
        $embed = new Embed($this->discord);
        $embed->setTitle($this->title);
        $embed->setDescription(
            '<@'. $this->message->user->id . '>' . ' took '
            . $medicationHistory->getDrug()->getName()->getRawValue()
            . ' '
            . $medicationHistory->getAmount()->toInt()
            . ' at '
            . Carbon::now()->format('H:m:s')
        );
        $embed->setColor('#eac645');
        $embed->setAuthor($this->message->user->username, $userAvatar);
        $embed->setThumbnail($botAvatar);
        $embed->setFooter('NewWorldMilitaryAdviser');

        return $embed;
    }

    public function toMedicationHistoryFailedEmbed(): Embed
    {
        $botAvatar = $this->discord->user->getAvatarAttribute('png');
        $embed = new Embed($this->discord);
        $embed->setTitle($this->title);
        $embed->setDescription('飲むな');
        $embed->setColor('#eac645');
        $embed->setAuthor($this->discord->user->username, $botAvatar);
        $embed->addFieldValues('失敗', 'のめませんでした', true);

        return $embed;
    }
}
