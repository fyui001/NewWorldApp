<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Courage\CoInt\CoPositiveInteger;
use Domain\Drugs\Drug;
use Domain\Drugs\DrugId;
use Domain\Drugs\DrugName;
use Domain\Drugs\DrugRepository as DrugRepositoryInterface;
use Domain\Drugs\DrugUrl;
use Domain\Exceptions\LogicException;
use Domain\Exceptions\NotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Infra\EloquentModels\Drug as DrugModel;

class DrugRepository implements DrugRepositoryInterface
{
    public function findDrug(DrugId $drugId): Drug
    {
        $model = DrugModel::where(['id' => $drugId->getRawValue()])->first();

        if (!$model) {
            throw new NotFoundException();
        }

        return $model->toDomain();
    }

    public function findDrugByName(DrugName $drugName): Drug
    {
        $model = DrugModel::where(['name' => $drugName->getRawValue()])->first();

        if (!$model) {
            throw new NotFoundException();
        }

        return $model->toDomain();
    }

    public function getPaginator(): LengthAwarePaginator
    {
        return DrugModel::paginate(15);
    }

    public function create(DrugName $drugName, DrugUrl $drugUrl): Drug
    {
        $model = new DrugModel;
        $model->drug_name = $drugName->getRawValue();
        $model->url = $drugUrl->getRawValue();

        $model->save();

        return $model->toDomain();
    }

    public function update(Drug $drug): Drug
    {
        $model = DrugModel::where(['id' => $drug->getId()->getRawValue()])->first();
        $model->drug_name = $drug->getName()->getRawValue();
        $model->url = $drug->getUrl()->getRawValue();

        $model->save();

        return $model->toDomain();
    }

    public function delete(DrugId $drugId): void
    {
        $model = DrugModel::where(['id' => $drugId->getRawValue()])->first();

        if (!$model) {
            throw new NotFoundException();
        }

        $result = $model->delete();

        if (!$result) {
            throw new LogicException();
        }
    }
}
