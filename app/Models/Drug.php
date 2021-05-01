<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Model as AppModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Drug extends AppModel
{

    protected $table = 'drugs';

    protected $guarded = [
        'id',
    ];

    /**
     * @return HasMany
     */
    public function medicationHistories(): HasMany {

        return $this->hasMany('App\Models\MedicationHistory', 'drug_id');

    }

}
