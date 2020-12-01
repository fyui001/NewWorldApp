<?php

declare(strict_types=1);

namespace App\Http\Requests\Drugs;

use App\Models\Drug;
use App\Http\Requests\Request as AppRequest;

class UpdateDrugRequest extends AppRequest
{

    public function authorize(): bool {

        return me() && me()->can('update', Drug::class);

    }

    /**
     * rules
     *
     * @return array|string[]
     */
    public function rules(): array {

        return [
            'drug_name' => 'required|string|max:255',
            'url' => 'required|url',
        ];

    }

    /**
     * message
     *
     * @return array|string[]
     */
    public function message(): array {

        return [
            'drug_name.required' => '薬物名は必須です',
            'url.required' => 'URLは必須です',
            'url.url' => '有効なURLではありません',
        ];

    }

}
