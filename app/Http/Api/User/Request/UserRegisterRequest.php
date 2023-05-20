<?php

declare(strict_types=1);

namespace App\Http\Api\User\Request;

use App\Http\Requests\Request as AppRequest;
use Domain\Common\RawPassword;
use Domain\User\UserId;

class UserRegisterRequest extends AppRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer',
            'password' => 'required|string|min:8',
            'password_confirm' => 'required|same:password',
        ];
    }

    public function getUserId(): UserId
    {
        return new UserId((int)$this->input('user_id'));
    }

    public function getUserRawPassword(): RawPassword
    {
        return new RawPassword($this->input('password'));
    }
}
