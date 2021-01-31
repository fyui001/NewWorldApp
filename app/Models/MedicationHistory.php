<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Model as AppModel;

class MedicationHistory extends AppModel
{
    protected $table = 'medication_histories';

    protected $guarded = [
        'id',
    ];

    public function user() {

        return $this->belongsTo('App\Models\User', 'user_id');

    }

    public function drug() {

        return $this->belongsTo('App\Models\Drug', 'drug_id');

    }

}
