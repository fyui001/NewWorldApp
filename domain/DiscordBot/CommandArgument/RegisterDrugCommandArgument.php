<?php

declare(strict_types=1);

namespace Domain\DiscordBot\CommandArgument;

use Domain\Drug\DrugName;

class RegisterDrugCommandArgument
{
    private DrugName $drugName;

    public function __construct(array $arg)
    {
        $this->drugName = new DrugName($arg[0]);
    }

    public function getDrugName(): DrugName
    {
        return $this->drugName;
    }
}
