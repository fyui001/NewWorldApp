<?php

namespace Domain\DiscordBot;

use Courage\CoString;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Domain\Drug\DrugDomainService;
use Domain\Drug\DrugName;
use Domain\Drug\DrugUrl;
use Domain\Exception\NotFoundException;
use Domain\MedicationHistory\MedicationHistoryAmount;
use Domain\MedicationHistory\MedicationHistoryDomainService;
use Domain\User\UserId;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Infra\Discord\EmbedHelper\DrugRegisterHelper;
use Infra\Discord\EmbedHelper\HelloHelper;
use Infra\Discord\EmbedHelper\MedicationHistoryHelper;
use Infra\Discord\MessageSender;
use Infra\Exceptions\InvalidArgumentException;

class DiscordBotDomainService
{
    private CoString $wikiApiUrl;
    private CoString $wikiViewPageUrl;
    private MessageSender $messageSender;

    public function __construct (
        private DrugDomainService $drugDomainService,
        private MedicationHistoryDomainService $medicationHistoryDomainService,
    ) {
        $this->wikiApiUrl = new CoString('https://ja.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro&explaintext&redirects=1&titles=');
        $this->wikiViewPageUrl = new CoString('https://ja.wikipedia.org/wiki/');
    }

    public function hello(Discord $discord, Message $message): void
    {
        $this->messageSender = new MessageSender($message);
        $this->messageSender->sendEmbed(
            (new HelloHelper($discord))->convertIntoDiscordEmbed(),
        );
    }

    public function registerDrug(array $args, Discord $discord, Message $message): void
    {
        $this->messageSender = new MessageSender($message);

        $drugName = new CoString($args[0]);
        $drugRegisterHelper = new DrugRegisterHelper($discord, $message);

        $result = Http::get($this->wikiApiUrl . $drugName->getRawValue());

        if (empty($result) || isset($result['query']['redirects'])) {
            $this->messageSender->sendEmbed(
                $drugRegisterHelper->convertIntoDiscordEmbedFailure(),
            );
        }

        foreach ($result['query']['pages'] as $key => $value) {
            if (isset($value['title'])) {
                $drugName = new DrugName($value['title']);
            }
        }

        try {
            $url = new DrugUrl($this->wikiViewPageUrl->getRawValue() . $drugName->getRawValue());
            $drug = $this->drugDomainService->createDrug(
                $drugName,
                $url,
            );

            $this->messageSender->sendEmbed(
                $drugRegisterHelper->convertInToDiscordEmbed($drug),
            );
        } catch (\Exception $e) {
            Log::warning($e->getMessage());
            $this->messageSender->sendEmbed(
                $drugRegisterHelper->convertIntoDiscordEmbedFailure(),
            );
        }
    }

    public function medication(array $args, Discord $discord, Message $message): void
    {
        $this->messageSender = new MessageSender($message);

        $medicationHistoryHelper = new MedicationHistoryHelper($discord, $message);

        $drug = $this->drugDomainService->findDrugByName(
            new DrugName($args[0]),
        );

        try {
            $medicationHistory = $this->medicationHistoryDomainService->createByUserId(
                new UserId($message->user->id),
                $drug->getId(),
                new MedicationHistoryAmount($args[1]),
            );

            $this->messageSender->sendEmbed(
                $medicationHistoryHelper->toMedicationHistoryCreatedEmbed($medicationHistory),
            );
        } catch (\InvalidArgumentException| NotFoundException $e) {
            Log::warning($e->getMessage());
            $this->messageSender->sendEmbed(
                $medicationHistoryHelper->toMedicationHistoryFailedEmbed(),
            );
        }
    }
}
