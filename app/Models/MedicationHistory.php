<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Model as AppModel;
use Kyslik\ColumnSortable\Sortable;

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

    public function user() {

        return $this->belongsTo('App\Models\User', 'user_id');

    }

    public function drug() {

        return $this->belongsTo('App\Models\Drug', 'drug_id');

    }

}
