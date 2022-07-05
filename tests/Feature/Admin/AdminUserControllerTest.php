<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->adminLogin();
    }

    public function testIndex()
    {
        $this->get(route('admin.admin_users.index'))->assertOk();
    }

    public function testCreate()
    {
        $this->get(route('admin.admin_users.create'))->assertOk();
    }

    public function testEdit()
    {
        $this->get(route('admin.admin_users.edit', $this->drug->getId()))->assertOk();
    }
}
