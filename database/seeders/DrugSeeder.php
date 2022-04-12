<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DrugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('drugs')->insert([
            'drug_name' => 'フルニトラゼパム',
            'url' => 'https://ja.wikipedia.org/wiki/%E3%83%95%E3%83%AB%E3%83%8B%E3%83%88%E3%83%A9%E3%82%BC%E3%83%91%E3%83%A0',
        ]);

        DB::table('drugs')->insert([
            'drug_name' => 'ゾルピデム',
            'url' => 'https://ja.wikipedia.org/wiki/%E3%82%BE%E3%83%AB%E3%83%94%E3%83%87%E3%83%A0',
        ]);
    }
}
