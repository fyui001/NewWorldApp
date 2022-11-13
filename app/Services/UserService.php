<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransfer\Drug\DrugHashMap;
use App\DataTransfer\User\UserMedicationHistory;
use App\DataTransfer\User\UserMedicationHistoryDetailList;
use App\DataTransfer\User\UserMedicationHistoryList;
use Domain\Common\RawPassword;
use Domain\Common\Token;
use Domain\Drug\DrugDomainService;
use Domain\Exception\DuplicateEntryException;
use Domain\Exception\InvalidArgumentException;
use Domain\Exception\NotFoundException;
use Domain\MedicationHistory\MedicationHistory;
use Domain\MedicationHistory\MedicationHistoryDomainService;
use Domain\User\User;
use Domain\User\UserDomainService;
use Domain\User\UserId;
use Domain\User\UserStatus;
use Illuminate\Support\Facades\Auth;
use App\Services\Service as AppService;
use App\Services\Interfaces\UserServiceInterface;

class UserService extends AppService implements UserServiceInterface
{
    public function __construct(
        private UserDomainService $userDomainService,
        private MedicationHistoryDomainService $medicationHistoryDomainService,
        private DrugDomainService $drugDomainService,
    ) {
    }

    /**
     * ユーザー情報取得
     *
     * @param User $user
     * @return array
     */
    public function getUserDetail(User $user): array
    {
        try {
            $user = $this->userDomainService->getUserById($user->getId());

            $medicationHistoryList = $this->medicationHistoryDomainService->getListByUserId(
                $user->getId(),
            );

            $userMedicationHistoryList = new UserMedicationHistoryList([]);
            $drugList = $this->drugDomainService->getDrugList();
            $drugHashMap = new DrugHashMap($drugList);
            foreach ($medicationHistoryList as $medicationHistory) {
                /** @var MedicationHistory $medicationHistory */
                $userMedicationHistoryList[
                    (string)$medicationHistory->getId()->getRawValue()
                ] = $this->buildDetail($medicationHistory, $drugHashMap);
            }

            $userAndMedicationHistoryDetailList = new UserMedicationHistoryDetailList(
                $user,
                $userMedicationHistoryList,
            );

            return [
                'status' => true,
                'errors' => null,
                'data' => $userAndMedicationHistoryDetailList->toArray(),
            ];
        } catch (NotFoundException $e) {
            return [
                'status' => false,
                'errors' => [
                    'key' => 'user_notfound',
                ],
                'data' => null,
            ];
        }
    }

    /**
     * ログイン
     *
     * @param UserId $userId
     * @param RawPassword $rawPassword
     * @return array
     */
    public function login(UserId $userId, RawPassword $rawPassword): array
    {
        $credentials = [
            'user_id' => $userId->getRawValue(),
            'password' => $rawPassword->getRawValue(),
            'status' => UserStatus::STATUS_VALID,
        ];

        if (!Auth::guard('api')->attempt($credentials)) {
            return [
                'status' => false,
                'errors' => [
                    'key' => 'login_failure',
                ],
                'data' => null,
            ];
        }

        $user = $this->userDomainService->getUserByUserId($userId)->toArray();
        $accessToken = auth('api')->claims([
            'guard' => 'api'
        ])->attempt($credentials);

        return [
            'status' => true,
            'errors' => null,
            'data' => [
                'user' => $user,
                'access_token' => $accessToken,
            ],
        ];
    }

    /**
     * 登録
     *
     * @param UserId $userId
     * @param RawPassword $rawPassword
     * @return array
     */
    public function register(
        UserId $userId,
        RawPassword $rawPassword,
    ): array {
        try {
            $user = $this->userDomainService->getUserByUserId($userId);

            if ($user->getStatus()->isRegistered()) {
                return [
                    'status' => false,
                    'errors' => [
                        'key' => 'duplicate_entry',
                    ],
                    'data' => null,
                ];
            }

            $result = $this->userDomainService->userPasswordRegister(
                $user->getId(),
                $rawPassword,
                UserStatus::STATUS_VALID
            );

            if (!$result) {
                return [
                    'status' => false,
                    'errors' => [
                        'key' => 'internal_server_error',
                    ],
                    'data' => null,
                ];
            }

            return [
                'status' => true,
                'errors' => null,
                'data' => null,
            ];
        } catch (NotFoundException $e) {
            return [
                'status' => false,
                'errors' => [
                    'key' => 'notfound',
                ],
                'data' => null,
            ];
        } catch (DuplicateEntryException $e) {
            return [
                'status' => false,
                'errors' => [
                    'key' => 'duplicate_entry',
                ],
                'data' => null,
            ];
        }
    }

    public function definitiveRegister(Token $definitiveRegisterToken): array
    {
        try {
            $result = $this->userDomainService->definitiveRegister($definitiveRegisterToken);

            if (!$result) {
                return [
                    'status' => false,
                    'errors' => [
                        'key' => 'invalid_token',
                    ],
                    'data' => null,
                ];
            }

            return [
                'status' => true,
                'errors' => null,
                'data' => null,
            ];
        } catch (InvalidArgumentException $e) {
            return [
                'status' => false,
                'errors' => [
                    'key' => 'invalid_token',
                ],
                'data' => null,
            ];
        }
    }

    private function buildDetail(
        MedicationHistory $medicationHistory,
        DrugHashMap $drugHashMap,
    ): UserMedicationHistory {
        $drug = $drugHashMap->get((string)$medicationHistory->getDrugId()->getRawValue());
        return new UserMedicationHistory($medicationHistory, $drug);
    }
}
