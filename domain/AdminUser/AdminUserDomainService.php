<?php

declare(strict_types=1);

namespace Domain\AdminUser;

use Courage\CoInt\CoPositiveInteger;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminUserDomainService
{
    private AdminUserRepository $adminUserRepository;

    public function __construct(AdminUserRepository $adminUserRepository)
    {
        $this->adminUserRepository = $adminUserRepository;
    }

    public function getPaginator(): LengthAwarePaginator
    {
        return $this->adminUserRepository->getPaginator();
    }

    public function createAdminUser(
        AdminUserId $adminUserId,
        AdminUserHashedPassword $adminUserHashedPassWord,
        AdminUserName $adminUserName,
        AdminUserRole $adminUserRole,
        AdminUserStatus $adminUserStatus
    ): AdminUser {
        return $this->adminUserRepository->create(
            $adminUserId,
            $adminUserHashedPassWord,
            $adminUserName,
            $adminUserRole,
            $adminUserStatus,
        );
    }

    public function updateAdminUser(AdminUser $adminUser): AdminUser
    {
        return $this->adminUserRepository->update($adminUser);
    }

    public function deleteAdminUser(AdminId $adminId): CoPositiveInteger
    {
        return $this->adminUserRepository->delete($adminId);
    }
}
