<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DrugControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testIndex()
    {
        $this->userLogin();

        $except = [
            'status' => true,
            'message' => '',
            'data' => [
                $this->drug->toArray(),
            ],
        ];

        $response = $this->json('GET',route('api.drugs.index'));

        $response->assertStatus(200)->assertJson($except);
    }
}
