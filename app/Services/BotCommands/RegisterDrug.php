<?php

declare(strict_types=1);

namespace App\Services\BotCommands;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Drugs\CreateDrugRequest;
use App\Services\DrugService;

class RegisterDrug
{

    protected string $commandName = '薬物登録';
    protected string $wikiApiUrl = 'https://ja.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro&explaintext&redirects=1&titles=';
    protected string $wikiViewPageUrl = 'https://ja.wikipedia.org/wiki/';
    protected string $drugName;

    /**
     * Run register drug command
     *
     * @param Discord $discord
     * @param Message $message
     * @param string $command
     * @param array $args
     * @return bool
     * @throws \Exception
     */
    public function run(Discord $discord, Message $message, string $command, array $args): bool
    {
        if ($this->commandName !== $command) {
            return false;
        }

        $bot = $discord->user;

        if ($message->author->user->id === $bot->id || $message->user->bot) {
            return false;
        }

        if (!$this->exec($args[0])) {
            $message->reply('薬物の登録に失敗しました');
            return false;
        }

        $message->reply($this->drugName . 'を登録しました');

        return true;
    }


    /**
     * Exec register drug
     *
     * @param string $drugName
     * @return bool
     */
    public function exec(string $drugName): bool
    {
        $result = Http::get($this->wikiApiUrl . $drugName);

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
            'drug_name' => $this->drugName,
            'url' => $this->wikiViewPageUrl . $this->drugName,
        ]);

        $drugService = new DrugService();

        try {
            $serviceResult = $drugService->createDrug($serviceRequest);

            if (!$serviceResult['status']) {
                return false;
            }

        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return false;
        }

        return true;
    }

}
