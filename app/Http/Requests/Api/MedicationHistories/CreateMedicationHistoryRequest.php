<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\MedicationHistories;

use App\Http\Requests\Request as AppRequest;
use Infra\EloquentModels\MedicationHistory;


class CreateMedicationHistoryRequest extends AppRequest
{
    public function authorize(): bool
    {
        return \Auth::guard('api')->user()->can('create', MedicationHistory::class);
    }

    /**
     * rules
     *
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|numeric',
            'drug_name' => 'required|string',
            'amount' => 'required|numeric',
        ];
    }

    /**
     * messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'ユーザーIDは必須です',
            'drug_name.required' => '薬物名は必須です',
            'amount.required' => '服薬量は必須です',
        ];
    }
}
