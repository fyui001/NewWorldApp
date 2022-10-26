<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use App\Http\Requests\Request as AppRequest;

class ApiRequest extends AppRequest
{
    public function rules(): array
    {
        return [];
    }
}
