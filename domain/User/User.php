<?php

declare(strict_types=1);

namespace Domain\User;

use Courage\CoList;
use Domain\Base\BaseListValue;

class User
{
    private Id $id;
    private UserId $userId;
    private UserName $userName;
    private IconUrl $iconUrl;
    private UserStatus $userStatus;

    public function __construct(
        Id $id,
        UserId $userId,
        UserName $userName,
        IconUrl $iconUrl,
        UserStatus $userStatus
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->userName = $userName;
        $this->iconUrl = $iconUrl;
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

    public function getStatus(): UserStatus
    {
        return $this->userStatus;
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
