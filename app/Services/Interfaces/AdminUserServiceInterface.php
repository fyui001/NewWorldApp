<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Models\AdminUser;
use App\Http\Requests\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use \Illuminate\Contracts\Auth\Authenticatable;

interface AdminUserServiceInterface
{
    public function getUsers(): LengthAwarePaginator;
    public function createUser(Request $request): AdminUser;
    public function updateUser(AdminUser $adminUser, Request $request);
    public function deleteUser(AdminUser $adminUser);
    public function apiTokenView(Authenticatable $adminUser): string;
    public function updateApiToken(): array;
}
