<?php

declare(strict_types=1);

namespace Infra\EloquentModels;

use Domain\Common\CreatedAt;
use Domain\Drug\Drug as DrugDomain;
use Domain\Drug\DrugId;
use Domain\Drug\DrugName;
use Domain\Drug\DrugUrl;
use Domain\MedicationHistory\MedicationHistory as MedicationHistoryDomain;
use Domain\MedicationHistory\Amount;
use Domain\MedicationHistory\MedicationHistoryId;
use Domain\User\IconUrl;
use Domain\User\Id;
use Domain\User\User as UserDomain;
use Domain\User\UserHashedPassword;
use Domain\User\UserId;
use Domain\User\UserName;
use Domain\User\UserStatus;
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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function drug(): BelongsTo
    {
        return $this->belongsTo(Drug::class, 'drug_id');
    }

    public function toDomain(): MedicationHistoryDomain
    {
        return new MedicationHistoryDomain(
            new MedicationHistoryId((int)$this->id),
            new Id((int)$this->user_id),
            new DrugId((int)$this->drug_id),
            new Amount((float)$this->amount),
            CreatedAt::forStringTime((string)$this->created_at),
        );
    }
}
