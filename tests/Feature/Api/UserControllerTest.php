<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Domain\User\UserDomainService;
use Domain\User\UserStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Infra\Discord\DiscordBotClient;
use Infra\EloquentModels\User;
use Tests\Feature\FeatureTestCase as TestCase;

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
        $response = $this->json('GET', route('api.users.show'));

        $response->assertStatus(401)
            ->assertJson([
                'status' => false,
                'errors' => [
                    'type' => 'unauthorized',
                ],
                'message' => '401 Unauthorized.',
                'data' => null,
            ]);

        $this->userLogin();

        $response = $this->json('GET', route('api.users.show'));

        $expectData = [
            'user' => [
                'id' => $this->user->getId()->getRawValue(),
                'userId' => $this->user->getUserId()->getRawValue(),
                'name' => $this->user->getName()->getRawValue(),
                'iconUrl' => $this->user->getIconUrl()->getRawValue(),
                'status' => $this->user->getStatus()->rawString()->getRawValue(),
                'medicationHistories' => [
                    [
                        'id' => $this->medicationHistory->getId()->getRawValue(),
                        'drug' => $this->drug->toArray(),
                        'amount' => $this->medicationHistory->getAmount()->getRawValue(),
                        'createdAt' => $this->medicationHistory->getCreatedAt()->getDetail(),
                    ],
                ],
            ],
        ];

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'data' => $expectData,
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
        $model->icon_url = 'https://example.com';
        $model->password = '';
        $model->status = UserStatus::STATUS_UNREGISTERED->getValue()->getRawValue();

        $model->save();
    }
}
