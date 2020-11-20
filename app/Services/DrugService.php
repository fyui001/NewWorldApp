<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\Request;
use App\Services\Service as AppService;
use App\Models\Drug;
use App\Services\Interfaces\DrugServiceInterface;
use Illuminate\Pagination\LengthAwarePaginator;


class DrugService extends AppService implements DrugServiceInterface
{

    public function getDrugs(): LengthAwarePaginator {

        return Drug::paginate(15);

    }

    /**
     * Create a drug
     *
     * @param Request $request
     * @return Drug
     */
    public function createDrug(Request $request): Drug {
        $result = Drug::create([
            'drug_name' => $request->get('drug_name'),
            'url' => $request->get('url'),
        ]);

        if (empty($result)) {
            throw new Exception('Failed to create');
        }

        return $result;

    }

}
