<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Model as AppModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kyslik\ColumnSortable\Sortable;

class Drug extends AppModel
{

    use Sortable;

    protected $table = 'drugs';

    protected $guarded = [
        'id',
    ];

    public $sortable = [
        'id',
        'drug_name',
    ];

    /**
     * @return HasMany
     */
    public function medicationHistories(): HasMany {

        return $this->hasMany('App\Models\MedicationHistory', 'drug_id');

    }

}
