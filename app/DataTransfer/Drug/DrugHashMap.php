<?php

declare(strict_types=1);

namespace App\DataTransfer\Drug;

use Domain\Base\BaseHashMap;
use Domain\Drug\Drug;
use Domain\Drug\DrugList;

class DrugHashMap extends BaseHashMap
{
    public function __construct(DrugList $drugList)
    {
        $hashMap = [];
        foreach ($drugList as $drug) {
            /** @var Drug $drug */
            $hashMap[(string)$drug->getId()->getRawValue()] = $drug;
        }
        parent::__construct($hashMap);
    }
}
