<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase as TestCase;

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

    public function testCreate()
    {
        $this->userLogin();

        $params = [
            'drug_name' => 'ゾルピデム',
            'url' => 'https://ja.wikipedia.org/wiki/%E3%82%BE%E3%83%AB%E3%83%94%E3%83%87%E3%83%A0',
        ];

        $response = $this->json('POST', route('api.drugs.create'), $params);

        $except = [
            'status' => true,
            'message' => '',
            'data' => null,
        ];

        $response->assertStatus(200)
            ->assertJson($except);
    }

    public function testShow()
    {
        $this->userLogin();

        $response = $this->json('GET', route('api.drugs.show', $this->drug->getId()));
        $except = [
            'status' => true,
            'message' => '',
            'errors' => null,
            'data' => $this->drug->toArray(),
        ];

        $response->assertStatus(200)
            ->assertJson($except);

        $response = $this->json('GET', route('api.drugs.show', 316));

        $except = [
            'status' => false,
            'message' => 'Drug notfound.',
            'errors' => [
                'type' => 'drug_notfound'
            ],
            'data' => null,
        ];

        $response->assertStatus(404)
            ->assertJson($except);
    }

    public function testShowName()
    {
        $this->userLogin();

        $params = [
            'drug_name' => 'フルニトラゼパム',
        ];

        $response = $this->json('GET', route('api.drugs.show.name'), $params);

        $except = [
            'status' => true,
            'message' => '',
            'data' => $this->drug->toArray(),
        ];

        $response->assertStatus(200)
            ->assertJson($except);

        $params = [
            'drug_name' => '高田憂希',
        ];

        $response = $this->json('GET', route('api.drugs.show.name'), $params);

        $except = [
            'status' => false,
            'message' => 'Drug notfound.',
            'errors' => [
                'type' => 'drug_notfound'
            ],
            'data' => null,
        ];

        $response->assertStatus(404)
            ->assertJson($except);
    }
}
