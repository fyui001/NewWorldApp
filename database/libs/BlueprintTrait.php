<?php
declare(strict_types=1);

namespace Database\Libs;

trait BlueprintTrait
{
    protected function dateTimes(\Illuminate\Database\Schema\Blueprint $blueprint): void
    {
        $blueprint->dateTime('created_at')->nullable()->comment('作成日時');
        $blueprint->dateTime('updated_at')->nullable()->comment('更新日時');
    }
}
