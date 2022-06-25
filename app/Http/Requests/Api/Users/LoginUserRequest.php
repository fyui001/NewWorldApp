<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\Request as AppRequest;
use Domain\Base\BaseValue;
use Domain\User\UserId;

class LoginUserRequest extends AppRequest
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer',
            'password' => 'required|string',
        ];
    }

    public function getUserId(): UserId
    {
        return new UserId((int)$this->input('user_id'));
    }

    public function getPasswordAsBaseValue(): BaseValue
    {
        return new BaseValue($this->input('password'));
    }
}
