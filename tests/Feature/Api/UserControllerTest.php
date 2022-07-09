<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Domain\User\UserStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Infra\EloquentModels\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
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
        $this->userLogin();

        $response = $this->json('GET', route('api.users.show'));

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
            ]);
    }

    public function testRegister()
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

        $model = new User();

        $model->user_id = 930316;
        $model->name = '高田憂希';
        $model->icon_url = '';
        $model->password = '';
        $model->status = UserStatus::STATUS_UNREGISTERED->getValue()->getRawValue();

        $model->save();

        $response = $this->json('POST', route('api.users.register'), $params);
        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'registered',
                'errors' => null,
                'data' => null,
            ]);
    }
}
