<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testShowLoginForm(): void
    {
        $this->get(route('admin.auth.login'))->assertOk();
    }

    public function testLogin(): void
    {
        $params = [
            'user_id' => 'takada_yuki',
            'password' => 'takada_yuki0316',
        ];

        $this->post('/admin/auth/login', $params)
            ->assertRedirect(route('admin.top_page'));
    }
}
