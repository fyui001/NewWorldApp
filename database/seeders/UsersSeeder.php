<?php

namespace Database\Seeders;

use Domain\Common\CreatedAt;
use Domain\Common\UpdatedAt;
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
            'status' => 1,
            'created_at' => CreatedAt::now()->getSqlTimeStamp(),
            'updated_at' => UpdatedAt::now()->getSqlTimeStamp(),
        ]);
    }
}
