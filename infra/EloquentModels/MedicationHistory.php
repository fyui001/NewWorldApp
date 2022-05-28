<?php

declare(strict_types=1);

namespace Infra\EloquentModels;

use Domain\Drug\Drug as DrugDomain;
use Domain\Drug\DrugId;
use Domain\Drug\DrugName;
use Domain\Drug\DrugUrl;
use Domain\MedicationHistory\MedicationHistory as MedicationHistoryDomain;
use Domain\MedicationHistory\MedicationHistoryAmount;
use Domain\MedicationHistory\MedicationHistoryId;
use Domain\User\IconUrl;
use Domain\User\Id;
use Domain\User\User as UserDomain;
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
            new UserDomain(
                new Id((int)$this->user->id),
                new UserId((int)$this->user->user_id),
                new UserName($this->user->name),
                new IconUrl($this->user->icon_url),
                UserStatus::tryFrom((int)$this->user->status),
            ),
            new DrugDomain(
                new DrugId((int)$this->drug->id),
                new DrugName($this->drug->drug_name),
                new DrugUrl($this->drug->url),
            ),
            new MedicationHistoryAmount((float)$this->amount)
        );
    }
}
