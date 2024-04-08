<?php

declare(strict_types=1);

namespace App\Services;

use App\DataTransfer\User\UserMedicationHistoryDetail;
use App\DataTransfer\User\UserMedicationHistoryDetailList;
use App\DataTransfer\User\UserMedicationHistoryPaginator;
use Domain\Common\Paginator\Paginate;
use Domain\Common\RawPassword;
use Domain\Common\Token;
use Domain\Drug\DrugDomainService;
use Domain\Exception\DuplicateEntryException;
use Domain\Exception\InvalidArgumentException;
use Domain\Exception\NotFoundException;
use Domain\MedicationHistory\MedicationHistory;
use Domain\MedicationHistory\MedicationHistoryDomainService;
use Domain\MedicationHistory\MedicationHistoryRepository;
use Domain\User\User;
use Domain\User\UserDomainService;
use Domain\User\UserId;
use Domain\User\UserStatus;
use Illuminate\Support\Facades\Auth;
use App\Services\Service as AppService;

class UserService extends AppService
{
    public function __construct(
        private readonly UserDomainService $userDomainService,
        private readonly MedicationHistoryDomainService $medicationHistoryDomainService,
        private readonly DrugDomainService $drugDomainService,
        private readonly MedicationHistoryRepository $medicationHistoryRepository,
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

            return [
                'status' => true,
                'errors' => null,
                'data' => [
                    'user' => $user->toArray(),
                ],
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
        $accessToken = Auth::guard('api')->attempt($credentials);

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
            $result = $this->userDomainService->userPasswordRegister(
                $userId,
                $rawPassword,
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

    public function getMedicationHistoryPaginator(User $user, Paginate $paginate): array
    {
        $result = $this->medicationHistoryDomainService->getPaginateByUserId(
            $user->getId(),
            $paginate,
        );

        $userMedicationHistoryDetailArr = [];

        foreach ($result->toArray() as $key => $item) {
            /** @var MedicationHistory $item */
            $drug = $this->drugDomainService->show($item->getDrugId());
            $medicationHistoryDetail = new UserMedicationHistoryDetail($item, $drug);

            $userMedicationHistoryDetailArr[$key] = $medicationHistoryDetail->toArray();
        }

        $userMedicationHistoryDetailList = new UserMedicationHistoryDetailList(
            $user,
            $userMedicationHistoryDetailArr
        );

        $medicationHistoryDetailPaginator = new UserMedicationHistoryPaginator(
            $userMedicationHistoryDetailList,
            $this->medicationHistoryRepository->getCount(),
            $paginate,
        );

        return [
            'status' => true,
            'errors' => null,
            'data' => $medicationHistoryDetailPaginator->toArray()
        ];
    }

}
