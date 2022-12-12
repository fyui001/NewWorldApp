<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Drugs;

use App\Http\Requests\Api\ApiRequest;
use Domain\Drug\DrugName;

class ShowNameDrugRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * rules
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'drug_name' => 'required|string',
        ];
    }

    /**
     * messages
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'drug_name.required' => '薬物名は必須です',
        ];
    }

    public function getDrugName(): DrugName
    {
        return new DrugName($this->input('drug_name'));
    }
}
