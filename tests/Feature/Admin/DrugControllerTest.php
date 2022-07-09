<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DrugControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->adminLogin();
    }

    public function testIndex()
    {
        $this->get(route('admin.drugs.index'))->assertOk();
    }

    public function testCreate()
    {
        $this->get(route('admin.drugs.create'))->assertOk();
    }

    public function testStore()
    {
        $params = [
            'drug_name' => 'ゾルピデム',
            'url' => 'https://ja.wikipedia.org/wiki/%E3%82%BE%E3%83%AB%E3%83%94%E3%83%87%E3%83%A0',
        ];

        $this->post(route('admin.drugs.store'), $params)
            ->assertRedirect(route('admin.drugs.index'))
            ->assertSessionHas('success');;
    }

    public function testEdit()
    {
        $this->get(route('admin.drugs.edit', $this->drug->getId()))->assertOk();
    }

    public function testUpdate()
    {
        $params = [
            'drug_name' => 'ゾルピデム',
            'url' => 'https://ja.wikipedia.org/wiki/%E3%82%BE%E3%83%AB%E3%83%94%E3%83%87%E3%83%A0',
        ];

        $this->post(route('admin.drugs.update', $this->drug->getId()), $params)
            ->assertRedirect(route('admin.drugs.index'))
            ->assertSessionHas('success');
    }

    public function testDelete()
    {
        $this->post(route('admin.drugs.delete', $this->drug->getId()))
            ->assertRedirect(route('admin.drugs.index'))
            ->assertSessionHas('success');
    }
}
