<?php

declare(strict_types=1);

namespace App\Http\Requests\Drugs;

use App\Models\Drug;
use App\Http\Requests\Request as AppRequest;


class CreateDrugRequest extends AppRequest
{

    /**
     * check authorize
     * @return bool
     */
    public function authorize(): bool {

        return me() && me()->can('create', Drug::class) || \Auth::user();

    }

    /**
     * rules
     *
     * @return array
     */
    public function rules(): array {

        return [
            'drug_name' => 'required|string|max:255',
            'url' => 'required|url',
        ];

    }

    /**
     * messages
     *
     * @return array
     */
    public function messages(): array {

        return [
            'drug_name.required' => '薬物名は必須です',
            'url.required' => 'URLは必須です',
            'url.url' => '有効なURLではありません',
        ];

    }

}
