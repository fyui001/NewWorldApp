<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Drugs;

use App\Http\Requests\Request as AppRequest;
use Domain\Drug\DrugId;

class ShowDrugRequest extends AppRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function getDrugId(): DrugId
    {
        return new DrugId((int)$this->route('drugId'));
    }
}
