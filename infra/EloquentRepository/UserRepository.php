<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Domain\Drugs\DrugId;
use Domain\Exceptions\NotFoundException;
use Domain\MedicationHistories\MedicationHistory;
use Domain\MedicationHistories\MedicationHistoryAmount;
use Domain\MedicationHistories\MedicationHistoryId;
use Domain\MedicationHistories\MedicationHistoryList;
use Domain\Users\IconUrl;
use Domain\Users\Id;
use Domain\Users\User;
use Domain\Users\UserAndMedicationHistory;
use Domain\Users\UserHashedPassword;
use Domain\Users\UserId;
use Domain\Users\UserName;
use Domain\Users\UserRepository as UserRepositoryInterface;
use Domain\Users\UserStatus;
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
