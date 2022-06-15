<?php

namespace Domain\DiscordBot;

use Courage\CoString;
use Domain\Drug\DrugDomainService;
use Domain\Drug\DrugName;
use Domain\Drug\DrugUrl;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DiscordBotDomainService
{
    protected CoString $wikiApiUrl;
    protected CoString $wikiViewPageUrl;

    public function __construct (
        private DrugDomainService $drugDomainService,
    ) {
        $this->wikiApiUrl = new CoString('https://ja.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&exintro&explaintext&redirects=1&titles=');
        $this->wikiViewPageUrl = new CoString('https://ja.wikipedia.org/wiki/');
    }

    public function hello(): string
    {
        return 'Watching you';
    }

    public function registerDrug(array $args): string
    {
        $drugName = new CoString($args[0]);

        $result = Http::get($this->wikiApiUrl . $drugName->getRawValue());

        if (empty($result) || isset($result['query']['redirects'])) {
            return 'Failure';
        }

        foreach ($result['query']['pages'] as $key => $value) {
            if (isset($value['title'])) {
                $drugName = new DrugName($value['title']);
            }
        }

        try {
            $url = new DrugUrl($this->wikiViewPageUrl->getRawValue() . $drugName->getRawValue());
            $this->drugDomainService->createDrug(
                $drugName,
                $url,
            );
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return '薬物の登録に失敗しました';

        }

        return $drugName . 'を登録しました';
    }
}
