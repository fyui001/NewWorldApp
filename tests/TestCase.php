<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createAdminUser(): void
    {
        DB::table('admin_users')->insert([
            'user_id' => 'takada_yuki',
            'password' => Hash::make('hogehoge'),
            'name' => '高田憂希',
            'role' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function createDrug(): void
    {
        DB::table('drugs')->insert([
            'drug_name' => 'フルニトラゼパム',
            'url' => 'https://ja.wikipedia.org/wiki/%E3%83%95%E3%83%AB%E3%83%8B%E3%83%88%E3%83%A9%E3%82%BC%E3%83%91%E3%83%A0',
        ]);
    }

    public function createMedicationHistory(): void
    {
        DB::table('medication_histories')->insert([
            'user_id' => 1,
            'drug_id' => 1,
            'amount' => 2,
        ]);
    }

    public function createUser(): void
    {
        DB::table('users')->insert([
            'user_id' => '19890308',
            'name' => '松井恵理子',
            'icon_url' => '',
            'password' => Hash::make('hogehoge'),
            'access_token' => '',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
