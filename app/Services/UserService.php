<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransfer\MedicationHistory\MedicationHistoryDetail;
use App\DataTransfer\MedicationHistory\MedicationHistoryDetailList;
use App\DataTransfer\User\UserMedicationHistory;
use App\DataTransfer\User\UserMedicationHistoryDetailList;
use App\DataTransfer\User\UserMedicationHistoryList;
use Domain\Common\RawPassword;
use Domain\Drug\DrugDomainService;
use Domain\Exception\NotFoundException;
use Domain\MedicationHistory\MedicationHistory;
use Domain\MedicationHistory\MedicationHistoryDomainService;
use Domain\User\Id;
use Domain\User\User;
use Domain\User\UserDomainService;
use Domain\User\UserHashedPassword;
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
            foreach ($medicationHistoryList as $key => $medicationHistory) {
                $userMedicationHistoryList[$key] = $this->buildDetail($medicationHistory);
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
     * @param Id $id
     * @param UserHashedPassword $hashedPassword
     * @return array
     */
    public function register(
        UserId $userId,
        UserHashedPassword $hashedPassword,
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

            $result = $this->userDomainService->userRegister(
                $user->getId(),
                $hashedPassword,
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
        }
    }

    private function buildDetail(MedicationHistory $medicationHistory): UserMedicationHistory
    {
        $drug = $this->drugDomainService->show($medicationHistory->getDrugId());
        return new UserMedicationHistory($medicationHistory, $drug);
    }
}
