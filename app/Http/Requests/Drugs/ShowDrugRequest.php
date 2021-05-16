<?php

declare(strict_types=1);

namespace App\Http\Requests\Drugs;

use App\Http\Requests\Request as AppRequest;
use App\Models\Drug;

class ShowDrugRequest extends AppRequest
{
    public function authorize(): bool {
        return me() && me()->can('show', Drug::class) ||  \Auth::user();
    }

    /**
     * rules
     *
     * @return string[]
     */
    public function rules(): array {
        return [
            'drug_name' => 'required|string',
        ];
    }

    /**
     * messages
     *
     * @return string[]
     */
    public function messages(): array {
        return [
            'drug_name.required' => '薬物名は必須です',
        ];
    }
}
