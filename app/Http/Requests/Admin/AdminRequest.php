<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request as AppRequest;

class AdminRequest extends AppRequest
{
    public function rules(): array
    {
        return [];
    }
}
