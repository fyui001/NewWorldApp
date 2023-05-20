<?php

declare(strict_types=1);

namespace App\Http\Api\User\Request;

use App\Http\Requests\Request as AppRequest;
use Domain\Common\Token;

class UserDefinitiveRegister extends AppRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'definitive_register_token' => 'required|string',
        ];
    }

    public function getToken(): Token
    {
        return new Token($this->input('definitive_register_token'));
    }
}
