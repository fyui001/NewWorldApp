<?php

declare(strict_types=1);

namespace App\Services\BotCommands;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\Drugs\CreateDrugRequest;
use App\Services\Interfaces\DrugServiceInterface;
use App\Services\DrugService;

class RegisterDrug
{

    protected string $commandName = '薬物登録';
    protected string $wikiApiUrl = 'https://ja.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro&explaintext&redirects=1&titles=';
    protected string $wikiViewPageUrl = 'https://ja.wikipedia.org/wiki/';
    protected string $drugName;

    public function run(Discord $discord, Message $message, string $command, array $args): bool
    {
        if ($this->commandName !== $command) {
            return false;
        }

        $bot = $discord->user;

        if ($message->author->user->id === $bot->id || $message->user->bot) {
            return false;
        }

        $result = Http::get($this->wikiApiUrl . $args[0]);

        if (empty($result) || isset($result['query']['redirects'])) {
            return false;
        }

        foreach ($result['query']['pages'] as $key => $value) {
            if (isset($value['title'])) {
                $this->drugName = $value['title'];
            }
        }

        $serviceRequest = new CreateDrugRequest();
        $serviceRequest->merge([
            'drug_name' => $args[0],
            'url' => $this->wikiViewPageUrl . $this->drugName,
        ]);

        $drugService = new DrugService();

        $serviceResult = $drugService->createDrug($serviceRequest);

        if (!$serviceResult['status']) {
            return false;
        }

        $message->reply($this->drugName . 'を登録しました');

        return true;
    }
}
