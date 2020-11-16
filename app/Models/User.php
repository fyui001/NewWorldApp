<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Model as AppModel;

class User extends AppModel
{

    protected $table = 'users';

    protected $fillable = [
        'name',
        'password',
        'is_registered',
        'del_flg',
    ];

    public function MedicationHistory() {

        return $this->hasMany('App\Model\MedicationHistory', 'drug_id');

    }

}
