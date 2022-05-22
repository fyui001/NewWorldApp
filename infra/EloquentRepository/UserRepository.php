<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Domain\Drug\DrugId;
use Domain\Exception\NotFoundException;
use Domain\MedicationHistory\MedicationHistory;
use Domain\MedicationHistory\MedicationHistoryAmount;
use Domain\MedicationHistory\MedicationHistoryId;
use Domain\MedicationHistory\MedicationHistoryList;
use Domain\User\IconUrl;
use Domain\User\Id;
use Domain\User\User;
use Domain\User\UserAndMedicationHistory;
use Domain\User\UserHashedPassword;
use Domain\User\UserId;
use Domain\User\UserName;
use Domain\User\UserRepository as UserRepositoryInterface;
use Domain\User\UserStatus;
use Infra\EloquentModels\User as UserModel;

class UserRepository implements UserRepositoryInterface
{
    private const WITH_MODEL = [
        'medicationHistories.drug',
    ];

    public function getUserByIdWithMedicationHistories(Id $id): UserAndMedicationHistory
    {
        $model = UserModel::with(self::WITH_MODEL)->where([
            'id' => $id->getRawValue(),
        ])->first()->toArray();

        $medicationHistoryList = new MedicationHistoryList([]);
        foreach ($model['medication_histories'] as $key => $value) {
            $medicationHistoryList[$key] = new MedicationHistory(
                new MedicationHistoryId((int)$value['id']),
                new Id((int)$value['user_id']),
                new DrugId((int)$value['drug_id']),
                new MedicationHistoryAmount((float)$value['amount'])
            );
        }

        return new UserAndMedicationHistory(
            new User(
                new Id((int)$model['id']),
                new UserId((int)$model['id']),
                new UserName($model['name']),
                new IconUrl($model['icon_url']),
                UserStatus::tryFrom((int)$model['status']),
            ),
            new MedicationHistoryList(
                $medicationHistoryList->map(function(MedicationHistory $medicationHistory) {
                    return $medicationHistory->toArray();
                })->toArray()
            )
        );
    }

    public function getUserByUserId(UserId $userId): User
    {
        $model = UserModel::where([
            'user_id' => $userId->getRawValue(),
        ])->first()->toArray();

        if (!$model) {
            throw new NotFoundException();
        }

        return new User(
            new Id((int)$model['id']),
            new UserId((int)$model['user_id']),
            new UserName($model['name']),
            new IconUrl($model['icon_url']),
            UserStatus::tryFrom((int)$model['status']),
        );
    }

    public function userRegister(
        Id $id,
        UserHashedPassword $password,
        UserStatus $userStatus
    ): bool {
        $model = UserModel::where([
            'id' => $id->getRawValue(),
        ])->first();

        return $model->update([
            'password' => $password->getRawValue(),
            'status' => $userStatus->getValue()->getRawValue(),
        ]);
    }
}
