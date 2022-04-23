<?php

declare(strict_types=1);

namespace Domain\AdminUsers;

class AdminUser
{
    private AdminId $adminId;
    private AdminUserId $adminUserId;
    private AdminUserHashedPassword $password;
    private AdminUserName $adminUserName;
    private AdminUserRole $adminUserRole;
    private AdminUserStatus $adminUserStatus;

    public function __construct(
        AdminId $adminId,
        AdminUserId $adminUserId,
        AdminUserHashedPassword $password,
        AdminUserName $adminUserName,
        AdminUserRole $adminUserRole,
        AdminUserStatus $adminUserStatus
    ) {
        $this->adminId = $adminId;
        $this->adminUserId = $adminUserId;
        $this->password = $password;
        $this->adminUserName = $adminUserName;
        $this->adminUserRole = $adminUserRole;
        $this->adminUserStatus = $adminUserStatus;
    }

    public function getId(): AdminId
    {
        return $this->adminId;
    }

    public function getUserId(): AdminUserId
    {
        return $this->adminUserId;
    }

    public function getPassword(): AdminUserHashedPassword
    {
        return $this->password;
    }

    public function getName(): AdminUserName
    {
        return $this->adminUserName;
    }

    public function getRole(): AdminUserRole
    {
        return $this->adminUserRole;
    }

    public function getStatus(): AdminUserStatus
    {
        return $this->adminUserStatus;
    }
}
