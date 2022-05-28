<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Courage\CoInt\CoPositiveInteger;
use Domain\Drug\DrugId;
use Domain\Exception\LogicException;
use Domain\Exception\NotFoundException;
use Domain\MedicationHistory\MedicationHistory;
use Domain\MedicationHistory\MedicationHistoryAmount;
use Domain\MedicationHistory\MedicationHistoryId;
use Domain\MedicationHistory\MedicationHistoryList;
use Domain\MedicationHistory\MedicationHistoryRepository as MedicationHistoryRepositoryInterface;
use Domain\User\Id as UserId;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Infra\EloquentModels\MedicationHistory as MedicationHistoryModel;

class MedicationHistoryRepository implements MedicationHistoryRepositoryInterface
{
    private const WITH_MODEL = [
        'drug',
        'user',
    ];

    public function getPaginator(): LengthAwarePaginator
    {
        return MedicationHistoryModel::sortable()->with(self::WITH_MODEL)->paginate(15);
    }

    public function getCountMedicationTake(DrugId $drugId): CoPositiveInteger
    {
        return new CoPositiveInteger(
            MedicationHistoryModel::where(['drug_id' => $drugId->getRawValue()])->count()
        );
    }

    public function getListByUserId(UserId $userId): MedicationHistoryList
    {
        $builder = MedicationHistoryModel::where([
            'user_id' => $userId->getRawValue()
        ]);
        /* @var $collection Collection */
        $collection = $builder->get();

        return new MedicationHistoryList($collection->map(function ($model) {
            /** @var $model MedicationHistoryModel */
            return $model->toDomain();
        })->toarray());
    }

    public function create(UserId $userId, MedicationHistoryAmount $amount): MedicationHistory
    {
        $model = new MedicationHistoryModel();

        $model->user_id = $userId->getRawValue();
        $model->amount = $amount->getRawValue();

        $model->save();

        return $model->toDomain();
    }

    public function update(MedicationHistory $medicationHistory): MedicationHistory
    {
        $model = MedicationHistoryModel::where([
            'id' => $medicationHistory->getId()->getRawValue()
        ])->first();

        $model->amount = (string)$medicationHistory->getAmount()->getRawValue();

        $model->save();

        return $model->toDomain();
    }

    public function delete(MedicationHistoryId $id): CoPositiveInteger
    {
        $model = MedicationHistoryModel::where(['id' => $id->getRawValue()]);

        if (!$model) {
            throw new NotFoundException();
        }

        $result = $model->delete();

        if (!$result) {
            throw new LogicException();
        }

        return new CoPositiveInteger($result);
    }
}
