<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_id' => '19890308',
            'name' => '松井恵理子',
            'icon_url' => '',
            'password' => Hash::make('hogehoge'),
            'access_token' => '',
            'is_registered' => 0,
            'del_flg' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
