<?php

declare(strict_types=1);

namespace App\Http\Requests\MedicationHistories;

use App\Models\MedicationHistory;
use App\Http\Requests\Request as AppRequest;

class UpdateMedicationHistoryRequest extends AppRequest
{

    public function authorize(): bool {
        return me() && me()->can('update', MedicationHistory::class);
    }

    /**
     * rules
     *
     * @return array|string[]
     */
    public function rules(): array {
        return [
            'amount' => 'required|numeric'
        ];
    }

    /**
     * message
     *
     * @return array|string[]
     */
    public function messages(): array {
        return [
            'amount.required' => '服薬量は必須です',
        ];
    }
}
