<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Model as AppModel;

class MedicationHistory extends AppModel
{
    protected $table = 'medication_histories';

    protected $fillable = [
        'user_id',
        'drug_id'
    ];

    public function user() {

        return $this->belongsTo('App\Models\User', 'user_id');

    }

    public function drug() {

        return $this->belongsTo('App\Model\Drug', 'drug_id');

    }

}
