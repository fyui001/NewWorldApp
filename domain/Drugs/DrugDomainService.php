<?php

declare(strict_types=1);

namespace Domain\Drugs;

use Courage\CoInt\CoPositiveInteger;
use Illuminate\Pagination\LengthAwarePaginator;

class DrugDomainService
{
    private DrugRepository $drugRepository;

    public function __construct(DrugRepository $drugRepository)
    {
        $this->drugRepository = $drugRepository;
    }

    public function findDrug(DrugId $drugId): Drug
    {
        return $this->drugRepository->findDrug($drugId);
    }

    public function findDrugByName(DrugName $drugName): Drug
    {
        return $this->drugRepository->findDrugByName($drugName);
    }

    public function getPaginator(): LengthAwarePaginator
    {
        return $this->drugRepository->getPaginator();
    }

    public function createDrug(DrugName $drugName, DrugUrl $drugUrl): Drug
    {
        return $this->drugRepository->create($drugName, $drugUrl);
    }

    public function updateDrug(Drug $drug): Drug
    {
        return $this->drugRepository->update($drug);
    }

    public function deleteDrug(DrugId $drugId): void
    {
        $this->drugRepository->delete($drugId);
    }
}
