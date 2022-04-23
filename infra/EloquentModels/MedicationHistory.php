<?php

declare(strict_types=1);

namespace Infra\EloquentModels;

use Infra\EloquentModels\Model as AppModel;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicationHistory extends AppModel
{

    use Sortable;

    protected $table = 'medication_histories';

    protected $guarded = [
        'id',
    ];

    public $sortable = [
        'id',
        'name',
        'drug_name',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function drug(): BelongsTo
    {
        return $this->belongsTo('App\Models\Drug', 'drug_id');
    }

}
