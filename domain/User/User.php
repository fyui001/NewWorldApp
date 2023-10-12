<?php

declare(strict_types=1);

namespace Domain\User;

use Domain\Common\HashedPassword;

class User
{
    public function __construct(
        private Id $id,
        private UserId $userId,
        private UserName $userName,
        private ?HashedPassword $userHashedPassword,
        private IconUrl $iconUrl,
        private UserStatus $userStatus
    ) {}

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

    public function getHashedPassword(): HashedPassword
    {
        return $this->userHashedPassword;
    }

    public function getIconUrl(): IconUrl
    {
        return $this->iconUrl;
    }

    public function getStatus(): UserStatus
    {
        return $this->userStatus;
    }

    public function hasHashedPassword(): bool
    {
        return !is_null($this->userHashedPassword);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId()->getRawValue(),
            'userId' => $this->getUserId()->getRawValue(),
            'name' => $this->getName()->getRawValue(),
            'iconUrl' => $this->getIconUrl()->getRawValue(),
            'status' => $this->getStatus()->displayName()->getRawValue(),
        ];
    }
}
