<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Domain\Common\RawPositiveInteger;
use Domain\Drug\DrugId;
use Domain\Exception\LogicException;
use Domain\Exception\NotFoundException;
use Domain\MedicationHistory\MedicationHistory;
use Domain\MedicationHistory\MedicationHistoryAmount;
use Domain\MedicationHistory\MedicationHistoryId;
use Domain\MedicationHistory\MedicationHistoryList;
use Domain\MedicationHistory\MedicationHistoryRepository as MedicationHistoryRepositoryInterface;
use Domain\User\Id;
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

    public function getCountMedicationTake(DrugId $drugId): RawPositiveInteger
    {
        return new RawPositiveInteger(
            MedicationHistoryModel::where(['drug_id' => $drugId->getRawValue()])->count()
        );
    }

    public function getListByUserId(Id $userId): MedicationHistoryList
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

    public function create(Id $userId, DrugId $drugId, MedicationHistoryAmount $amount): MedicationHistory
    {
        $model = new MedicationHistoryModel();

        $model->user_id = $userId->getRawValue();
        $model->drug_id = $drugId->getRawValue();
        $model->amount = $amount->getRawValue();

        $model->save();

        return $model->toDomain();
    }

    public function update(MedicationHistory $medicationHistory): MedicationHistory
    {
        $model = MedicationHistoryModel::where([
            'id' => $medicationHistory->getId()->getRawValue()
        ])->first();

        $model->amount = $medicationHistory->getAmount()->getRawValue();

        $model->save();

        return $model->toDomain();
    }

    public function delete(MedicationHistoryId $id): RawPositiveInteger
    {
        $model = MedicationHistoryModel::where(['id' => $id->getRawValue()]);

        if (!$model) {
            throw new NotFoundException();
        }

        $result = $model->delete();

        if (!$result) {
            throw new LogicException();
        }

        return new RawPositiveInteger($result);
    }
}
