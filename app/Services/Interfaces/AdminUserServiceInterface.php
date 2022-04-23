<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Http\Requests\Admin\AdminUsers\CreateAdminUserRequest;
use App\Http\Requests\Admin\AdminUsers\UpdateAdminUserRequest;
use Domain\AdminUsers\AdminId;
use Illuminate\Pagination\LengthAwarePaginator;

interface AdminUserServiceInterface
{
    public function getUsers(): LengthAwarePaginator;
    public function createUser(CreateAdminUserRequest $request): void;
    public function updateUser(AdminId $adminId, UpdateAdminUserRequest $request): void;
    public function deleteUser(AdminId $adminId): void;
}
