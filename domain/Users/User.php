<?php

declare(strict_types=1);

namespace Domain\Users;

class User
{
    private Id $id;
    private UserId $userId;
    private UserName $userName;
    private IconUrl $iconUrl;
    private UserHashedPassword $hashedPassword;
    private UserStatus $userStatus;

    public function __construct(
        Id $id,
        UserId $userId,
        UserName $userName,
        IconUrl $iconUrl,
        UserHashedPassword $hashedPassword,
        UserStatus $userStatus
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->userName = $userName;
        $this->iconUrl = $iconUrl;
        $this->hashedPassword = $hashedPassword;
        $this->userStatus = $userStatus;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getName(): UserName
    {
        return $this->userName;
    }

    public function getIconUrl(): IconUrl
    {
        return $this->iconUrl;
    }

    public function getPassword(): UserHashedPassword
    {
        return $this->hashedPassword;
    }

    public function getStatus(): UserStatus
    {
        return $this->userStatus;
    }
}
