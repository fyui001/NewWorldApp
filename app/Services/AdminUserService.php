<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Service as AppService;
use Domain\AdminUser\AdminId;
use Domain\AdminUser\AdminUserDomainService;
use Domain\AdminUser\AdminUserId;
use Domain\AdminUser\AdminUserList;
use Domain\AdminUser\AdminUserName;
use Domain\AdminUser\AdminUserRole;
use Domain\AdminUser\AdminUserStatus;
use Domain\Common\RawPassword;
use Exception;

class AdminUserService extends AppService
{
    private AdminUserDomainService $adminUserDomainService;

    public function __construct(AdminUserDomainService $adminUserDomainService)
    {
        $this->adminUserDomainService = $adminUserDomainService;
    }

    /**
     * Get all users from paginator.
     *
     * @return AdminUserList
     */
    public function getAdminUsers(): AdminUserList
    {
        return $this->adminUserDomainService->getAdminUserList();
    }

    /**
     * Create a user.
     *
     * @param AdminUserId $adminUserId
     * @param RawPassword $adminUserRawPassWord
     * @param AdminUserName $adminUserName
     * @param AdminUserRole $adminUserRole
     * @param AdminUserStatus $adminUserStatus
     * @return void
     */
    public function createUser(
        AdminUserId $adminUserId,
        RawPassword $adminUserRawPassWord,
        AdminUserName $adminUserName,
        AdminUserRole $adminUserRole,
        AdminUserStatus $adminUserStatus,
    ): void {
        $this->adminUserDomainService->createAdminUser(
            $adminUserId,
            $adminUserRawPassWord,
            $adminUserName,
            $adminUserRole,
            $adminUserStatus,
        );
    }

    /**
     * Update the user.
     *
     * @param AdminId $adminId
     * @param AdminUserId $adminUserId
     * @param RawPassword $adminUserRawPassWord
     * @param AdminUserName $adminUserName
     * @param AdminUserRole $adminUserRole
     * @param AdminUserStatus $adminUserStatus
     */
    public function updateUser(
        AdminId $adminId,
        AdminUserId $adminUserId,
        RawPassword $adminUserRawPassWord,
        AdminUserName $adminUserName,
        AdminUserRole $adminUserRole,
        AdminUserStatus $adminUserStatus,
    ): void {
        $this->adminUserDomainService->updateAdminUser(
            $adminId,
            $adminUserId,
            $adminUserRawPassWord,
            $adminUserName,
            $adminUserRole,
            $adminUserStatus,
        );
    }

    /**
     * Delete the user.
     *
     * @param AdminId $adminId
     * @throws Exception
     */
    public function deleteUser(AdminId $adminId): void
    {
        $this->adminUserDomainService->deleteAdminUser($adminId);
    }
}
