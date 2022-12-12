<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Drugs;


use App\Http\Requests\Api\ApiRequest;

class IndexDrugRequest extends ApiRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the requirest.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'page' => 'nullable|int',
            'per_page' => 'nullable|int',
            'order_by' => 'nullable|string',
            'sort' => 'nullable|string',
        ];
    }
}
