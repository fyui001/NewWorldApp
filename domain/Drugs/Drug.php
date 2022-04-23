<?php

declare(strict_types=1);

namespace Domain\Drugs;

class Drug
{
    private DrugId $drugId;
    private DrugName $drugName;
    private DrugUrl $drugUrl;

    public function __construct(DrugId $drugId, DrugName $drugName, DrugUrl $drugUrl)
    {
        $this->drugId = $drugId;
        $this->drugName = $drugName;
        $this->drugUrl = $drugUrl;
    }

    public function getId(): DrugId
    {
        return $this->drugId;
    }

    public function getName(): DrugName
    {
        return $this->drugName;
    }

    public function getUrl(): DrugUrl
    {
        return $this->drugUrl;
    }
}
