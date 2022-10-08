<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Http\Requests\Admin\AdminUsers\UpdateAdminUserRequest;
use Domain\AdminUser\AdminId;
use Domain\AdminUser\AdminUserId;
use Domain\AdminUser\AdminUserList;
use Domain\AdminUser\AdminUserName;
use Domain\AdminUser\AdminUserRole;
use Domain\AdminUser\AdminUserStatus;
use Domain\Common\RawPassword;

interface AdminUserServiceInterface
{
    public function getAdminUsers(): AdminUserList;
    public function createUser(
        AdminUserId $adminUserId,
        RawPassword $adminUserRawPassWord,
        AdminUserName $adminUserName,
        AdminUserRole $adminUserRole,
        AdminUserStatus $adminUserStatus,
    ): void;
    public function updateUser(
        AdminId $adminId,
        AdminUserId $adminUserId,
        RawPassword $adminUserRawPassWord,
        AdminUserName $adminUserName,
        AdminUserRole $adminUserRole,
        AdminUserStatus $adminUserStatus,
    ): void;
    public function deleteUser(AdminId $adminId): void;
}
