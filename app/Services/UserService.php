<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransfer\MedicationHistory\MedicationHistoryDetail;
use App\DataTransfer\MedicationHistory\MedicationHistoryDetailList;
use App\DataTransfer\User\UserAndMedicationHistoryDetailList;
use Domain\Common\RawPassword;
use Domain\Exception\NotFoundException;
use Domain\MedicationHistory\MedicationHistory;
use Domain\MedicationHistory\MedicationHistoryDomainService;
use Domain\User\Id;
use Domain\User\UserDomainService;
use Domain\User\UserHashedPassword;
use Domain\User\UserId;
use Domain\User\UserStatus;
use Illuminate\Support\Facades\Auth;
use App\Services\Service as AppService;
use App\Services\Interfaces\UserServiceInterface;

class UserService extends AppService implements UserServiceInterface
{
    private UserDomainService $userDomainService;
    private MedicationHistoryDomainService $medicationHistoryDomainService;

    public function __construct(
        UserDomainService $userDomainService,
        MedicationHistoryDomainService $medicationHistoryDomainService,
    ) {
        $this->userDomainService = $userDomainService;
        $this->medicationHistoryDomainService = $medicationHistoryDomainService;
    }

    /**
     * ユーザー情報取得
     *
     * @return array
     */
    public function getUser(): array
    {

        $user = Auth::guard('api')->user();

        if (empty($user)) {
            return [
                'status' => false,
                'errors' => [
                    'key' => 'unauthorized',
                ],
                'data' => null,
            ];
        }

        $user = $this->userDomainService->getUserById(
            new Id($user->getAuthIdentifier())
        );

        $medicationHistoryList = $this->medicationHistoryDomainService->getListByUserId(
            $user->getId(),
        );

        $medicationHistoryDetailList = new MedicationHistoryDetailList([]);
        foreach ($medicationHistoryList as $key => $medicationHistory) {
            $medicationHistoryDetailList[$key] = $this->buildDetail($medicationHistory)->toArray();
        }

        $userAndMedicationHistoryDetailList = new UserAndMedicationHistoryDetailList(
            $user,
            $medicationHistoryDetailList,
        );

        return [
            'status' => true,
            'errors' => null,
            'data' => $userAndMedicationHistoryDetailList->toArray(),
        ];
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

    private function buildDetail(MedicationHistory $medicationHistory): MedicationHistoryDetail
    {
        return new MedicationHistoryDetail($medicationHistory);
    }
}
