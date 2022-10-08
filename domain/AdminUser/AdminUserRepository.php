<?php

declare(strict_types=1);

namespace Domain\AdminUser;

use Domain\Common\HashedPassword;
use Domain\Common\RawPositiveInteger;

interface AdminUserRepository
{
    public function getAdminUserList(): AdminUserList;
    public function get(AdminId $adminId): AdminUser;
    public function getByUserId(AdminUserId $adminUserId): AdminUser;
    public function create(
        AdminUserId $adminUserId,
        HashedPassword $adminUserHashedPassWord,
        AdminUserName $adminUserName,
        AdminUserRole $adminUserRole,
        AdminUserStatus $adminUserStatus
    ): AdminUser;
    public function update(AdminUser $adminUser): AdminUser;
    public function delete(AdminId $adminId): RawPositiveInteger;
}
