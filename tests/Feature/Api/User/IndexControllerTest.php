<?php

declare(strict_types=1);

namespace Tests\Feature\Api\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase as TestCase;

class IndexControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
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

    public function testShow()
    {
        $response = $this->json('GET', route('api.users.show'));

        $response->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        $this->userLogin();

        $response = $this->json('GET', route('api.users.show'));

        $expectData = [
            'user' => [
                'id' => $this->user->getId()->getRawValue(),
                'userId' => $this->user->getUserId()->getRawValue(),
                'name' => $this->user->getName()->getRawValue(),
                'iconUrl' => $this->user->getIconUrl()->getRawValue(),
                'status' => $this->user->getStatus()->rawString()->getRawValue(),
            ],
        ];

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'data' => $expectData,
            ]);
    }

    public function testRegisterFiler()
    {
        $params = [
            'user_id' => 19890308,
            'password' => 'matsui_erico',
            'password_confirm' => 'matsui_erico'
        ];

        $response = $this->json('POST', route('api.users.register'), $params);
        $response->assertStatus(409)
            ->assertJson([
                'status' => false,
                'message' => 'Duplicate entry',
                'errors' => [
                    'type' => 'duplicate_entry'
                ],
                'data' => null,
            ]);

        $params = [
            'user_id' => 930316,
            'password' => 'takada_yuki',
            'password_confirm' => 'takada_yuki',
        ];

        $response = $this->json('POST', route('api.users.register'), $params);
        $response->assertStatus(404)
            ->assertJson([
                'status' => false,
                'message' => '404 Notfound.',
                'errors' => [
                    'type' => 'not_found',
                ],
                'data' => null,
            ]);
    }
}
