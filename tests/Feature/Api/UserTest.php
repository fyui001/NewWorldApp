<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->createUser();
    }

    public function testLoginSuccess()
    {
        $params = [
            'user_id' => 19890308,
            'password' => 'hogehoge',
        ];

        $response = $this->json('POST', route('api.users.login'), $params);
        $response->assertStatus(200)->assertJson([
            'status' => true,
            'data' => $response['data'],
        ]);

    }

    public function testLoginFailure() {
        $params = [
            'user_id' => 19890308,
            'password' => 'testtest',
        ];

        $response = $this->json('POST', route('api.users.login'), $params);
        $response->assertStatus(400)->assertJson([
            'status' => false,
            'message' => 'Login Failure',
            'errors' => [
                'type' => 'login_failure',
            ],
            'data' => null,
        ]);
    }
}
