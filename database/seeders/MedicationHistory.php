<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicationHistory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('medication_histories')->insert([
            'user_id' => 1,
            'drug_id' => 1,
            'amount' => 2,
        ]);

        DB::table('medication_histories')->insert([
            'user_id' => 1,
            'drug_id' => 2,
            'amount' => 10,
        ]);
    }
}
