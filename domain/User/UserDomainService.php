<?php

declare(strict_types=1);

namespace Domain\User;

use Domain\Common\RawPassword;
use Domain\Common\Token;
use Illuminate\Contracts\Hashing\Hasher;
use Infra\Discord\DiscordBotClient;

class UserDomainService
{

    public function __construct(
        private UserRepository $userRepository,
        private Hasher $hasher,
        private DiscordBotClient $discordBotClient,
    ) {
    }

    public function getUserById(Id $id): User
    {
        return $this->userRepository->get($id);
    }

    public function getUserByUserId(UserId $userId): User
    {
        return $this->userRepository->getUserByUserId($userId);
    }

    public function userPasswordRegister(
        Id $id,
        RawPassword $password,
        UserStatus $userStatus,
    ): bool {
        $result =  $this->userRepository->userRegister(
            $id,
            $password->hash($this->hasher),
            $userStatus,
        );

        $user = $this->userRepository->get($id);
        $token = $this->userRepository->getDefinitiveRegisterToken($id);
        $this->discordBotClient->sendDefinitiveRegisterUrlByDm($user->getUserId(), $token);


        return $result;
    }

    public function definitiveRegister(Token $definitiveRegisterToken): bool
    {
        return $this->userRepository->definitiveRegister($definitiveRegisterToken);
    }
}
