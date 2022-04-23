<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Courage\CoInt\CoPositiveInteger;
use Domain\Drugs\DrugId;
use Domain\Exceptions\LogicException;
use Domain\Exceptions\NotFoundException;
use Domain\MedicationHistories\MedicationHistory;
use Domain\MedicationHistories\MedicationHistoryAmount;
use Domain\MedicationHistories\MedicationHistoryId;
use Domain\MedicationHistories\MedicationHistoryRepository as MedicationHistoryRepositoryInterface;
use Domain\Users\Id as UserId;
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
