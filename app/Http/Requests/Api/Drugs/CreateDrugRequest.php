<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Drugs;

use App\Http\Requests\Request as AppRequest;

class CreateDrugRequest extends AppRequest
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
}
