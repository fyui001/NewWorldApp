<?php

declare(strict_types=1);

namespace Domain\DiscordBot\CommandArgument;

use Domain\Drug\DrugName;
use Domain\MedicationHistory\MedicationHistoryAmount;

class MedicationCommandArgument
{
    private DrugName $drugName;
    private MedicationHistoryAmount $amount;

    public function __construct(array $args)
    {
        $this->drugName = new DrugName($args[0]);
        $this->amount = new MedicationHistoryAmount((float)$args[1]);
    }

    public function getDrugName(): DrugName
    {
        return $this->drugName;
    }

    public function getAmount(): MedicationHistoryAmount
    {
        return $this->amount;
    }
}
