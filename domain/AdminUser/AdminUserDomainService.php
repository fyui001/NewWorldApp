<?php

declare(strict_types=1);

namespace Domain\AdminUser;

use Domain\Common\RawPassword;
use Domain\Common\RawPositiveInteger;
use Illuminate\Contracts\Hashing\Hasher;

class AdminUserDomainService
{
    public function __construct(
        private AdminUserRepository $adminUserRepository,
        private Hasher $hasher,
    ) {
    }

    public function getAdminUserList(): AdminUserList
    {
        return $this->adminUserRepository->getAdminUserList();
    }

    public function createAdminUser(
        AdminUserId $adminUserId,
        RawPassword $adminUserRawPassWord,
        AdminUserName $adminUserName,
        AdminUserRole $adminUserRole,
        AdminUserStatus $adminUserStatus,
    ): AdminUser {
        return $this->adminUserRepository->create(
            $adminUserId,
            $adminUserRawPassWord->hash($this->hasher),
            $adminUserName,
            $adminUserRole,
            $adminUserStatus,
        );
    }

    public function updateAdminUser(
        AdminId $adminId,
        AdminUserId $adminUserId,
        RawPassword $adminUserRawPassWord,
        AdminUserName $adminUserName,
        AdminUserRole $adminUserRole,
        AdminUserStatus $adminUserStatus,
    ): AdminUser {
        return $this->adminUserRepository->update(
            new AdminUser(
                $adminId,
                $adminUserId,
                $adminUserRawPassWord->hash($this->hasher),
                $adminUserName,
                $adminUserRole,
                $adminUserStatus,
            )
        );
    }

    public function deleteAdminUser(AdminId $adminId): RawPositiveInteger
    {
        return $this->adminUserRepository->delete($adminId);
    }
}
