<?php

declare(strict_types=1);

namespace App\Http\Api\User\Request;

use App\Http\Requests\Request as AppRequest;

class UserDetailRequest extends AppRequest
{
    public function rules(): array
    {
        return [];
    }
}
