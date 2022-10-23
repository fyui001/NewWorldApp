<?php

declare(strict_types=1);

namespace Domain\Common;

use Domain\Base\BaseTime;

class ExpiredAt extends BaseTime
{
    public static function makeExpiredAtTime()
    {
        return new static(strtotime('+ 30 minute', self::now()->getRawValue()));
    }
}
