<?php

declare(strict_types=1);

namespace App\Http\Api\Shered\Request;

use App\Http\Requests\Request as AppRequest;

class ApiRequest extends AppRequest
{
    public function rules(): array
    {
        return [];
    }
}
