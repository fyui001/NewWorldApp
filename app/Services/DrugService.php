<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Service as AppService;
use App\Models\Drug;
use App\Services\Interfaces\DrugServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;


class DrugService extends AppService implements DrugServiceInterface
{

    public function getDrugs(): LengthAwarePaginator {
        return Drug::paginate(15);
    }

}
