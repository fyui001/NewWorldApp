<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Drugs;

use App\Http\Requests\Api\ApiRequest;
use Domain\Drug\DrugName;
use Domain\Drug\DrugUrl;

class CreateDrugRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'drug_name' => 'required|string|max:255',
            'url' => 'required|url',
        ];
    }

    public function getDrugName(): DrugName
    {
        return new DrugName($this->input('drug_name'));
    }

    public function getUrl(): DrugUrl
    {
        return new DrugUrl($this->input('url'));
    }
}
