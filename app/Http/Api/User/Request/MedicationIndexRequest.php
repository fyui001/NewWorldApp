<?php

declare(strict_types=1);

namespace App\Http\Api\User\Request;

use App\Auth\User;
use App\Http\Api\Shered\Request\ApiRequest;
use Domain\User\User as UserDomain;


class MedicationIndexRequest extends ApiRequest
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

    public function getUserDomain(): UserDomain
    {
        /** @var User $user */
        return $this->loginUser();
    }
}
