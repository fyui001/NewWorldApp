<?php

declare(strict_types=1);

namespace Infra\EloquentModels;

use Domain\Drugs\DrugId;
use Domain\MedicationHistory\MedicationHistory as MedicationHistoryDomain;
use Domain\MedicationHistory\MedicationHistoryAmount;
use Domain\MedicationHistory\MedicationHistoryId;
use Domain\User\Id as UserId;
use Infra\EloquentModels\Model as AppModel;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicationHistory extends AppModel
{

    use Sortable;

    protected $table = 'medication_histories';

    protected $guarded = [
        'id',
        'user_id',
        'drug_id',
    ];

    public $sortable = [
        'id',
        'name',
        'drug_name',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('Infra\EloquentModels\User', 'user_id');
    }

    public function drug(): BelongsTo
    {
        return $this->belongsTo('Infra\EloquentModels\Drug', 'drug_id');
    }

    public function toDomain(): MedicationHistoryDomain
    {
        return new MedicationHistoryDomain(
            new MedicationHistoryId((int)$this->id),
            new UserId((int)$this->user_id),
            new DrugId((int)$this->drug_id),
            new MedicationHistoryAmount((float)$this->amount)
        );
    }
}
