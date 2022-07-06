<?php

declare(strict_types=1);

namespace Domain\AdminUser;

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

    public function hasHashedPassword(): bool
    {
        return !is_null($this->password);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->adminId->getRawValue(),
            'user_id' => $this->adminUserId->getRawValue(),
            'password' => $this->password->getRawValue(),
            'name' => $this->adminUserName->getRawValue(),
            'role' => $this->adminUserRole->getValue()->getRawValue(),
            'status' => $this->adminUserStatus->getValue()->getRawValue(),
        ];
    }
}
