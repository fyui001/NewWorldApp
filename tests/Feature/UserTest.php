<?php


namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    public function testLoginSuccess() {

        DB::table('users')->insert([
            'user_id' => 19890308,
            'name' => '松井恵理子',
            'icon_url' => '',
            'password' => Hash::make('hogehoge'),
            'access_token' => '',
            'is_registered' => 1,
            'del_flg' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $params = [
            'user_id' => 19890308,
            'password' => 'hogehoge',
        ];

        $response = $this->json('POST', route('admin.users.login'), $params);
        $response->assertStatus(200)->assertJson([
            'status' => true,
            'data' => $response['data'],
        ]);

    }

    public function testLoginFailure() {
        DB::table('users')->insert([
            'user_id' => 19890308,
            'name' => '松井恵理子',
            'icon_url' => '',
            'password' => Hash::make('hogehoge'),
            'access_token' => '',
            'is_registered' => 1,
            'del_flg' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $params = [
            'user_id' => 19890308,
            'password' => 'testtest',
        ];

        $response = $this->json('POST', route('admin.users.login'), $params);
        $response->assertStatus(400)->assertJson([
            'status' => false,
            'msg' => 'unauthorized',
        ]);

    }

}
