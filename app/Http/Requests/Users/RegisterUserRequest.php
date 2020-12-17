<?php

declare(strict_types=1);

namespace App\Http\Requests\Users;

use App\Http\Requests\Request as AppRequest;

class RegisterUserRequest extends AppRequest
{
    public function authorize(): bool {

        return true;

    }

    public function rules(): array {

        return [
            'user_id' => 'required|integer',
            'password' => 'required|string|min:8',
            'password_confirm' => 'required|same:password',
        ];

    }
}
