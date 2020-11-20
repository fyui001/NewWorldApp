<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Models\Drug;
use App\Http\Requests\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface DrugServiceInterface
{
    public function getDrugs(): LengthAwarePaginator;
}
